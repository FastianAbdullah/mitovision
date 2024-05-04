<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Plan;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
//use App\Http\Controllers\Session;

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

    
        if (Auth::attempt($request->only('email', 'password')))
        {
            // Retrieve the logged-in user (doctor)

            $user = Auth::user();
           
            // Redirect user based on role
            if ($user->hasRole('super admin'))
            {
             
                return redirect()->route('admin.dashboard');
            } 
            elseif ($user->hasRole('doctor')) {
                // Retrieve the images uploaded by the user (doctor)
                $images = $user->images;

                // Extract the patient IDs from the images
                $patientIds = $images->pluck('patient_id')->unique()->values()->toArray();

                // Retrieve the associated patients
                $patients = Patient::whereIn('id', $patientIds)->get();

                // Pass patients data to the doctor dashboard view
                session(['patients' => $patients]);

                // Redirect to the desired route
                return redirect()->route('doctor.dashboard');
            } else {
                // Default redirect if user has no role or unrecognized role
                return redirect()->route('login');
            }
        }
     
    }


    public function register_view(Request $request)
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        //Bydefault User 11 is the Super Admin
        $admin = User::find(11);
        $admin->assignRole('super admin');

        if ($admin && $admin->hasRole('super admin')) {
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
            'password' => Hash::make($request->password),
            'plan_id' => 1
        ]);

        $user->assignRole('doctor');


        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('doctor.dashboard');
        }

        return redirect('register')->withErrors('Error');


    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
    public function home()
    {
        $plans = Plan::all();
        return view('welcome',compact('plans'));
    }
    public function admin_dashboard()
    {
        return view('layouts.admin.app');
    }
    public function doctor_dashboard()
    {
        // Retrieve $patients data from the session
        $patients = session('patients');
    
        // Pass $patients data to the view
        // return view('layouts.doctor.app', ['patients' => $patients]);
        return view('sections.doctors.dashboard', ['patients' => $patients]);
    }

}
