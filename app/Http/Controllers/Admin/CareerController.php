<?php

namespace App\Http\Controllers\Admin;

use App\Career;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string',
            'location' => 'required|string',
            'pay' => 'required|numeric',
            'job_type' => 'required|string',
            'shift' => 'required|string',
            'responsibilities' => 'required|string',
            'requirements' => 'required|string',
        ]);

        Career::create([
            'position' => $request->position,
            'location' => $request->location,
            'pay' => $request->pay,
            'job_type' => $request->job_type,
            'shift' => $request->shift,
            'responsibilities' => $request->responsibilities,
            'requirements' => $request->requirements,
        ]);

        return redirect()->route('admin.jobs.create')->with('success', 'Job successfully uploaded.');
    }
 public function index()
    {
        $jobs = Career::all();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function edit($id)
    {
        $job = Career::findOrFail($id);
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'position' => 'required|string',
            'location' => 'required|string',
            'pay' => 'required|numeric',
            'job_type' => 'required|string',
            'shift' => 'required|string',
            'responsibilities' => 'required|string',
            //'requirements' => 'required|string',
        ]);

        $job = Career::findOrFail($id);
        $job->update([
            'position' => $request->position,
            'location' => $request->location,
            'pay' => $request->pay,
            'job_type' => $request->job_type,
            'shift' => $request->shift,
            'responsibilities' => $request->responsibilities,
            //'requirements' => $request->requirements,
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Job successfully updated.');
    }

    public function destroy($id)
    {
        $job = Career::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'Job successfully deleted.');
    }

}
