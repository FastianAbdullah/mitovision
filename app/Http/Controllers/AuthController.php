<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        
        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect user based on role
            if (Auth::user()->hasRole('super admin'))
            {
                return redirect()->route('admin.dashboard');
            } 
            elseif (Auth::user()->hasRole('doctor'))
            {
                return redirect()->route('doctor.dashboard');
            }
            else
            {
                // Default redirect if user has no role or unrecognized role
                return redirect()->route('login');
            }
        }
    
        return redirect('login')->withErrors('Login Credentials Failed. Try Again');
    }
    public function register_view(Request $request)
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        //Bydefault User 11 is the Super Admin
        $admin = User::find(11);
        if ($admin && !$admin->hasRole('super admin')) {
            $admin->assignRole('super admin');
        }
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name, // Using 'name' from request
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'plan_id' => 1
        ]);

        $user->assignRole('doctor');
        

        if (\Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('doctor.dashboard');
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
    public function admin_dashboard()
    {
        return view('layouts.admin.app');
    }
    public function doctor_dashboard()
    {
        return view('layouts.doctor.app');
    }
    
}
