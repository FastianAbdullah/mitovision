<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Image;

class PatientController extends Controller
{
    public function index()
{
    // Retrieve the user ID of the currently authenticated user
    $userId = Auth::id();
    
    // Retrieve distinct patient IDs associated with the user thats currently logged in
    $patientIds = Image::where('user_id', $userId)
                       ->distinct()
                       ->pluck('patient_id');

    // Retrieve the patient records associated with the retrieved patient IDs
    $patients = Patient::whereIn('id', $patientIds)->get();

    return view('admin_panel.doctor_panel.patients.index', ['patients' => $patients]);
}
}
