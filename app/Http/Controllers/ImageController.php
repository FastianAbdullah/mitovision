<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
     
        // Validate request data
        $validatedData = $this->validateImageData($request);
    
        // Create or update patient record
        $patient = $this->createOrUpdatePatient($validatedData);
    
        // Handle image upload
        $response = $this->handleImageUpload($request, $validatedData, $patient);
    
        // Handle API response
        return $this->handleApiResponse($response);
    }
    
    private function validateImageData(Request $request)
    {
        return $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif', // Adjust file validation rules as needed
            'patient_phone' => 'string|required|size:11',
            'patient_name' => '',
            'gender' => '',
            'blood_group' => '',
            'address' => '',
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
    
            // Associate the image with the patient and save it
            $patient->images()->save($image);
    
            // Sending the Image Filename to Flask API
            return Http::get('http://127.0.0.1:5001/predict', [
                'image_filename' => basename($path),
            ]);
        }
    }
    
    private function handleApiResponse($response)
    {
        if ($response->successful()) {
            $predictions = $response->json();
            $outputs = $predictions['outputs'];
            $result = $predictions['prediction'];
    
            return response()->json([
                'outputs' => $outputs,
                'result' => $result
            ]);
        } else {
            $errorMessage = 'Failed to get predictions from the API.';
            $statusCode = $response->status();
            // $imagePath = storage_path("app/$path");
    
            // Flash API error message to session
            session()->flash('api_error', 'Failed to get predictions from the API.');
    
            // Return JSON response with error message
            return response()->json([
                'error' => 'Failed to get predictions from the API.',
                'status_code' => $statusCode
            ], $statusCode); // Return appropriate status code
        }
    }
    
    
}