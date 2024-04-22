<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate(([
            'email' => 'required',
            'password' => 'required'
        ]));

        if(\Auth::attempt($request->only('email', 'password')))
        {
            return redirect('home');
        }
      
        return redirect('login')->withErrors('Login Credentials Failed. Try Again');
    }
    public function register_view(Request $request)
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed'
        ]);
    
        $user = User::create([
            'name' => $request->name, // Using 'name' from request
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'pricing_id' => 1
        ]);
    
    
        if(\Auth::attempt($request->only('email', 'password')))
        {
            return redirect('auth.login');
        }
    
        return redirect('register')->withErrors('Error');
  
        
    }   
    public function logout()
    {
        \Session::flush();
        \Auth::logout();
        return redirect('login');
    }
    public function home()
    {
        return view('welcome');
    }
}
