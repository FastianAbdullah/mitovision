<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
class ReportController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        $reports = $user->reports()->get();

        return view('admin_panel.doctor_panel.reports',compact('reports'));
    }
    public function update($id, Request $request)
    {

        $report = Report::find($id);

      
        $report->description = $request->description;

      
        
        $report->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Patient updated successfully');
    }
}
