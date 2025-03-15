<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Career;
use Illuminate\Http\Request;

class JobApplicantController extends Controller
{
    public function create()
    {
        $careers = Career::all();
        return view('jobs.create',compact('careers')); // Make sure the view file is named correctly
    }

    public function store(Request $request)
    {
            // Validate the request
          $request->validate([
        'name' => 'required|string|max:255',
        'mobile_number' => 'required|string|max:15',
        'location' => 'required|string|max:255',
        'highest_qualification' => 'required|string',
        'qualification' => 'required|string|max:255',
        'resume_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'email' => 'required|email|max:255|',
    ]);

    
        // Create a new JobApplicant instance
        $applicant = new Applicant();
        $applicant->name = $request->name;
        $applicant->email = $request->email;
        $applicant->mobile_number = $request->mobile_number;
        $applicant->location = $request->location;
        $applicant->highest_qualification = $request->highest_qualification;
        $applicant->qualification = $request->qualification;
        $applicant->career_id = $request->career_id;  // Store the career_id
            if ($request->hasFile('resume_path')) { 
            $path = "assets/resumes/";
            $resume_name = $_FILES["resume_path"]["name"];
            $tmp = $_FILES["resume_path"]["tmp_name"];
            $resume_name = time() . '_' . $resume_name;
            if (move_uploaded_file($tmp, $path . $resume_name)) {
                $applicant->resume_path = $resume_name;
                $applicant->save();
                $request->session()->flash('success', 'Resume uploaded successfully!');
            } else {
                $request->session()->flash('error', 'There is some problem in uploading the resume');
                return redirect()->back();
            }
        } else {
            $applicant->resume_path = null;
        }
        $applicant->save();
    
        // Flash a success message to the session
        $request->session()->flash('success', 'Your application has been submitted successfully.');
    
        return redirect()->route('jobs.apply');
    }
    
}
