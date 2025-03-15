<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pending;
use App\Project;
use App\Employer;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use App\PendingQuestion as PQ;
use App\Question as Qs;
use Excel;
use App\Exports\AllProjects;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class JobController extends Controller
{
    public function pending(){
        if(!Auth::guard('admin')->check()){
            return redirect('/');
        }
        $pending = Pending::orderBy('created_at')->paginate(15);
        return view('admin.job.pending')->with([
            'pending' => $pending
        ]);
    }

    public function all(){
        if(!Auth::guard('admin')->check()){
            return redirect('/');
        }
        $jobs = Project::orderBy('created_at')->paginate(15);
        return view('admin.job.all')->with([
            'jobs' => $jobs
        ]);
    }
    
    // Active or Inactive
    public function projectStatus($id)
    {
        $job = Project::find($id);
    
        if ($job) {
            // Toggle the gigstatus
            $job->projectstatus = !$job->projectstatus;
            $job->save();
        }
    
        return back();
    }
    public function toggleVisibility($id)
    {
        $job = Project::find($id);
    
        if ($job) {
            // Toggle the visibility status (0 or 1)
            $job->is_visible = !$job->is_visible;
            $job->save();
        }
    
        // Log the value for debugging
        \Log::info('Visibility changed to: ' . $job->is_visible);
    
        return back();
    }
    public function approve(Request $request){
        if(!Auth::guard('admin')->check()){
            return redirect('/');
        }
        $pending = Pending::find($request->id);
        $job = new Project;

        $emp = Employer::find($pending->user);
        $job->title = $pending->title;
        $job->des = $pending->des;
        $job->cat = $pending->cat;
        $job->start = $pending->start;
        $job->end = $pending->end;
        $job->duration = $pending->duration;
        $job->stipend = $pending->stipend;
        $job->benefits = $pending->benefits;
        $job->place = $pending->place;
        $job->count = $pending->count;
        $job->skills = $pending->skills;
        $job->user = $pending->user;
        $job->proofs = $pending->proofs;
        $job->save();
        $pid = $pending->id;
        $pending->delete();
        $questions = PQ::where('pid',$pid)->get();
        foreach($questions as $qus){
            $q = new Qs;
            $q->pid = $job->id;
            $q->question = $qus->question;
            $q->save();
            $qus->delete();
        }

        // Mail
        
        
        Session()->flash('success','Project Approved');
        return redirect()->back();
    }

    public function delete(Request $request){
        if(!Auth::guard('admin')->check()){
            return redirect('/');
        }
        $pending = Pending::find($request->id);
        $emp = Employer::find($pending->user);
        $job = $pending;
        $pending->delete();

        // Mail
        

        Session()->flash('success','Project Rejected');
        return redirect()->back();
    }
    public function export_excel(){
        $projects = Project::get();
        if($projects->count()==0){
            Session()->flash('warning','No project found');
            return redirect()->back();
        }
        else{
            return Excel::download(new AllProjects(), 'projects.xlsx');
        }
    }
    public function makeMobile(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $project = Project::find($request->id);
        $project->mobile = 1;
        $project->save();
        $request->session()->flash('success', "The project has been made mobile specific");
        return redirect()->back();
    }
    public function undoMobile(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $project = Project::find($request->id);
        $project->mobile = 0;
        $project->save();
        $request->session()->flash('success', "The project has been removed from mobile specific");
        return redirect()->back();
    }
}
