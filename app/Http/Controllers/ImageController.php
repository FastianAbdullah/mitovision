<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Image;
use App\Models\Plan;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate request data
        $validatedData = $this->validateImageData($request);

        // Create or update patient record
        $patient = $this->createOrUpdatePatient($validatedData);

        // Handle image upload
        $imageAndResponse = $this->handleImageUpload($request, $validatedData, $patient);
        $image = $imageAndResponse['image'];
        $response = $imageAndResponse['response'];

        // Handle API response
        return $this->handleApiResponse($response,$image);
    }

    private function validateImageData(Request $request)
    {
        return $request->validate([
            'image' => 'required|image|jpeg,png,jpg', // Adjust file validation rules as needed
            'patient_phone' => 'string|required|size:11',
            'patient_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'address' => 'nullable|string|max:255',
        ]);
    }

    private function createOrUpdatePatient($validatedData)
    {
        return Patient::firstOrCreate(
            ['phone' => $validatedData['patient_phone']],
            [
                'name' => $validatedData['patient_name'],
                'gender' => $validatedData['gender'],
                'blood_group' => $validatedData['blood_group'],
                'address' => $validatedData['address'],
            ]
        );
    }

    private function handleImageUpload(Request $request, $validatedData, $patient)
    {
        if ($request->hasFile('image')) {
            // Store the uploaded file in the storage/app/public directory
            $path = $request->file('image')->store('images', 'public');
            $imageUrl = $path;

            // Create a new image record associated with the patient
            $image = new Image([
                'image' => $imageUrl,
                'user_id' => auth()->user()->id,
            ]);

            $patient->images()->save($image);

            // Sending the Image Filename to Flask API
            $response = Http::get('http://127.0.0.1:5001/predict', [
                'image_filename' => basename($path),
            ]);

            // Return both the created image instance and the HTTP response
            return ['image' => $image->id, 'response' => $response];
        }
    }

    private function handleApiResponse($response, $imageId)
    {
        if ($response->successful()) {
            $predictions = $response->json();
            $outputs = $predictions['outputs'];
            $result = $predictions['prediction'];

            // Save the prediction and other relevant data to the reports table
            $report = new Report([
                'prediction' => $result,
                'result_time' => now(),
                'user_id' => auth()->user()->id,
                'image_id' => $imageId,
            ]);

            // Save the report
            $report->save();

            // Return the predictions and outputs
            return response()->json([
                'outputs' => $outputs,
                'result' => $result
            ]);
        } else {
            $errorMessage = 'Failed to get predictions from the API.';
            $statusCode = $response->status();

            // Flash API error message to session
            session()->flash('api_error', 'Failed to get predictions from the API.');

            // Return JSON response with error message
            return response()->json([
                'error' => 'Failed to get predictions from the API.',
                'status_code' => $statusCode
            ], $statusCode); // Return appropriate status code
        }
    }
    public function check_limit(){

        $user_id = Auth::user()->getAuthIdentifier();
        $user = User::find($user_id);

        $user_plan = Plan::find($user['plan_id']);
        $user_images_count=$user->images()->count();

        if($user_images_count >= $user_plan['max_images']){
            return response()->json([
                'limit_cross' => true
            ]);
        }
        else{
            return response()->json([
                'limit_cross' => false
            ]);
        }
    }
}