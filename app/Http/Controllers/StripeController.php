<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StripeController extends Controller
{

    public function session(Request $request)
    {
        $id = $request->get("id");
        //retrive plan from id.
        $plan = Plan::find($id);
        //get login user_id.
        $user_id = Auth::user()->getAuthIdentifier();
        //get user data.
        $user = User::find($user_id);

        //check if plan and user's plan is below the selected plan.
        if ($plan && $user['plan_id'] < $plan['id']){

            \Stripe\Stripe::setApiKey(env('STRIPE_SK'));

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
                'success_url' => route('success', ['id' => $plan['id']]),
                'cancel_url'  => route('home'),
            ]);   
            
            return redirect()->away($session->url);
        }
        else{
            return redirect()->away(route('home'));
        }

    }

    public function success(Request $request)
    {
        //get plan_id by request.
        $plan_id = $request->get('id');
        //get user_id by Auth.
        if(!$plan_id){
            throw new HttpException(404,'Invalid Request');
        }
        else{
            $user_id = Auth::user()->getAuthIdentifier();
            //Update user plan_id.
            User::where('id', $user_id)->update(['plan_id' => $plan_id]);
        }

        return redirect()->away(route('home'));
    }
}
