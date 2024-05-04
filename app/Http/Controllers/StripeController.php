<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Stripe\StripeClient;
use Stripe\Webhook;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripeController extends Controller
{
    public function __construct(){
        $this->middleware("auth")->except(['donate']);
    }
    public function session(Request $request)
    {
        $id = $request->get("id");
        //retrive plan from id.
        $plan = Plan::find($id);
        //get login user_id.
        $user_id = Auth::user()->getAuthIdentifier();
        //get user data.
        $user = User::find($user_id);

        // $s_id_and_plan_id = [
        //     'plan_id'=> $plan['id'],
        //     'session_id' =>'{CHECKOUT_SESSION_ID}'
        // ];

        //check if plan and user's plan is below the selected plan.
        if ($plan && $user['plan_id'] < $plan['id']){

            $stripe= new StripeClient(Config::get('stripe.sk'));
            Stripe::setApiKey(Config::get('stripe.sk'));

            $stripe->customers->create([
                'metadata' => [
                    'plan_id'=> $plan['id'],
                ],
            ]);

            $session = \Stripe\Checkout\Session::create([
                'line_items'  => [
                    [
                        'price_data' => [
                            'currency'     => 'gbp',
                            'product_data' => [
                                'name' => $plan['plan'],
                                'description' => $plan['description'],
                            ],
                            'unit_amount'  => $plan['price'] * 100,
                        ],
                        'quantity'   => 1,
                    ],
                ],
                'mode'        => 'payment',
                'success_url' => route('success', ['id' => $plan['id']])."?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url'  => route('home'),
            ]);   
            
            return redirect()->away($session->url);
        }
        else{
            return redirect()->away(route('home'));
        }

    }

    public function success($plan_id,Request $request)
    {
        //get session_id by request.
        $session_id = $request->get('session_id');
        
        //try catch block so if invalid session_id then instead of website going down throw exception.
        try{
            Stripe::setApiKey(Config::get('stripe.sk'));            
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            //if no valid session or plan_id then also throw exception.
            if(!$session || !$plan_id)
                return throw new NotFoundHttpException;
        }
        catch(Exception $e){
            throw new NotFoundHttpException;
        }

        //get user_id by Auth.
        $user_id = Auth::user()->getAuthIdentifier();
        //Update user plan_id if not already updated.
        $user = User::where('id', $user_id)->firstOr('*');

        if(!$user->exists()){
            throw new NotFoundHttpException;
        }
        
        //if already updated in webhook event.
        if($user && $user['plan_id'] != $plan_id){
            $user->update(['plan_id' => $plan_id]);
        }

        return redirect()->away(route('home'));
    }

    public function webhook(){  
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = Config::get("stripe.wk");
        
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        
        //construct webhook event.
        try {
          $event = Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
        } catch(\UnexpectedValueException $e) {
            return response('exception occured',400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
          // Invalid signature
            return response('exception occured',400);
        }
        
        // Handle the event
        switch ($event->type) {
          case 'checkout.session.completed':
            //Stripe Configuration
            $stripe = new StripeClient(Config::get('stripe.sk'));
            
            //retrive customer.
            $customer = $stripe->customers->retrieve(
                $event->data->object->customer
            );

            //retrive plan id from customer metadata.
            $plan_id = $customer->metadata->plan_id;

            //if plan id does not exist throw exception
            if(!$plan_id){
                throw new NotFoundHttpException;
            }
            else{
                //get user_id by Auth.
                $user_id = Auth::user()->getAuthIdentifier();
                //Update user plan_id.
                User::where('id', $user_id)->update(['plan_id' => $plan_id]);
            }
          // ... handle other event types
          default:
            echo 'Received unknown event type ' . $event->type;
        }
        
        return response('OK',200);
    }

    public function donate(Request $request){

        $request->validate([
            'donationAmount'=> 'required|numeric|min:0',
            'currency' =>'required|string|in:usd,eur,gbp',
        ]);
        
        $amount  = $request->input('donationAmount');
        $currency = $request->input('currency');

        Stripe::setApiKey(Config::get('stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => $currency,
                        'product_data' => [
                            'name' => 'Donation',
                            'description' => 'Donate For a Better Cause',
                        ],
                        'unit_amount'  => $amount * 100,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('home'),
            'cancel_url'  => route('home'),
        ]);   
        
        return redirect()->away($session->url);

    }

}
