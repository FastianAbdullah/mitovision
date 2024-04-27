<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file validation rules as needed
            'patient_id' => 'required|integer',
            'patient_name' => 'required|string',
        ]);

     
     
    
        // Create a new image record in the database
       
    
        

        // Check if the request has the file
        if ($request->hasFile('image')) {
            // Get the file from the request
            $image = $request->file('image');
    
            // Store the uploaded file in the storage/app/public directory
            $path = $request->file('image')->store('images', 'public');
            $imageUrl = $path;
            // Sending the  Image Filename to Flask API
            $response = Http::get('http://127.0.0.1:5001/predict', [
                'image_filename' => basename($path),
            ]);
    
            // Handle the API response as needed
            if ($response->successful()) {  
                $predictions = $response->json();
                
             
                $outputs = $predictions['outputs']; 
                $result = $predictions['prediction']; 
                
                $imageData = [
                    'imgurl' => $imageUrl,
                    'user_id' => auth()->user()->id, // Assuming the user is authenticated
                    'patiend_id' => $validatedData['patient_id'],
                    'patient_name' => $validatedData['patient_name'],
                ];
             
                Image::create($imageData);

                return view('welcome', [
                    'outputs' => $outputs,
                    'result' => $result
                ]);
            } 
            else {
                $errorMessage = 'Failed to get predictions from the API.';
                $statusCode = $response->status();
                $imagePath = storage_path("app/$path");
    
                // Print the image path
                error_log("Image Path: $imagePath");
    
                // Return error message with status code
                return response()->json(['error' => $errorMessage, 'image_path' => $imagePath], $statusCode);
            }
        }
    
        
        // Return error message if no file is uploaded
        return response()->json(['error' => 'No image uploaded.'], 400);
    }
}