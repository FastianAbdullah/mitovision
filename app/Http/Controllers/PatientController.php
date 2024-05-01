<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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
    public function update($id, Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|size:11',
            'blood_group' => 'nullable|string|max:255',
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'address' => 'nullable|string|max:255',
        ]);
    
        // Find the patient by ID
        $patient = Patient::find($id);
    
        // Update the patient data
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->blood_group = $request->blood_group;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
    
        // Save the changes to the database
        $patient->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Patient updated successfully');
    }
    public function delete($id, Request $request)
{
    // Find the patient by ID
    $patient = Patient::find($id);

    if (!$patient) {
        return redirect()->back()->with('error', 'Patient not found');
    }

    try {
        // Use a database transaction to ensure atomicity
        DB::transaction(function () use ($patient) {
            // Delete related images
            $patient->images()->delete();

            // Now, delete the patient
            $patient->delete();
        });

        return redirect()->back()->with('success', 'Patient and related images deleted successfully');
    } catch (\Exception $e) {
        // If an error occurs, rollback the transaction
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to delete patient and related images');
    }
}
}
