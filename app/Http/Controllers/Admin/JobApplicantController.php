<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Applicant;
use Illuminate\Http\Request;

class JobApplicantController extends Controller
{
    public function index()
    {
        $applicants = Applicant::all();
        return view('admin.applicants.index', compact('applicants'));
    }

    public function markAsCalled($id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return redirect()->back()->with('error', 'Applicant not found.');
        }

        // Toggle the is_called field
        $applicant->is_called = !$applicant->is_called;
        $applicant->save();

        return redirect()->back()->with('success', 'Applicant status updated successfully.');
    }
}
