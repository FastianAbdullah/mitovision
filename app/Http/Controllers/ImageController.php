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
        // Validate the request data
        // $request->validate([
        //     'image' => 'required|image|max:2048', // max 2MB
        // ]);
    
        // Check if the request has the file
        if ($request->hasFile('image')) {
            // Get the file from the request
            $image = $request->file('image');
    
            // Store the uploaded file in the storage/app/public directory
            $path = $request->file('image')->store('images', 'public');
           
            // Send Image Filename to Flask API
            $response = Http::get('http://127.0.0.1:5001/predict', [
                'image_filename' => basename($path),
            ]);
    
            // Handle the API response as needed
            if ($response->successful()) {  
                $predictions = $response->json();
                
                return response()->json($predictions);
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