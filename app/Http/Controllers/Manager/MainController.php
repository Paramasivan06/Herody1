<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Manager;
use App\Project;
use App\Gig;
use App\Pending;
use App\GigCategory;
use App\CompletedGig as CJ;
use App\User;
use App\Employer;
use App\PendingGig;
use App\Task;
use App\PendingTask;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use App\PendingQuestion as PQ;
use App\Question as Qs;

class MainController extends Controller
{
    public function dashboard(){
        $manager = Manager::find(Auth::guard('manager')->id());
        return view('manager.pages.dashboard')->with([
            'manager' => $manager,
        ]);
    }

    //Projects Controller
    public function pendingjobs(){
        $jobs = Pending::orderBy('created_at','asc')->paginate(15);
        return view('manager.pages.pendingjobs')->with([
            'pending' => $jobs,
        ]);
    }
    
    public function jobApprove(Request $request){
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
        $sub = "Your Project has been accepted";
        $message="<p>Dear {$emp->name},</p><p>Your project, {$job->title}, has been accepted by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));
        
        Session()->flash('success','Project Approved');
        return redirect()->back();
    }

    public function jobReject(Request $request){
        $pending = Pending::find($request->id);

        $emp = Employer::find($pending->user);
        $job = $pending;
        $pending->delete();

        // Mail
        $sub = "Your Project has been rejected";
        $message="<p>Dear {$emp->name},</p><p>Your project, {$job->title}, has been rejected by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));

        Session()->flash('success','Project Deleted');
        return redirect()->back();
    }
    
    public function jobAll(){
        $jobs = Project::orderBy('updated_at')->paginate(15);
        return view('manager.pages.alljobs')->with([
            'jobs' => $jobs
        ]);
    }


    //Gigs Controller

    public function pendingGigs(){
        $campaigns = PendingGig::orderBy('created_at','asc')->paginate(15);
        return view('manager.pages.pendinggigs',compact('campaigns'));
    }
    public function allGigs(){
        $campaigns = Gig::orderBy('created_at','desc')->paginate(15);
        return view('manager.pages.allgigs',compact('campaigns'));
    }
    
    public function approveCampaign($id){
        $pending = PendingGig::find($id);
        $campaign = new Gig;
        $cat = GigCategory::find($pending->campaign_category);
        $campaign->cats = $pending->cats;
        $campaign->per_cost = $pending->per_cost;
        $campaign->campaign_title = $pending->campaign_title;
        $campaign->description = $pending->description;
        $campaign->brand = $pending->brand;
        $campaign->logo = $pending->logo;

        $campaign->user_id = $pending->user_id;
        $campaign->save();
        
        $tasks = PendingTask::where('cid',$pending->id)->get();
        foreach($tasks as $taske){
            $task = new Task;
            $task->cid = $campaign->id;
            $task->task = $taske->task;
            $task->save();
            $taske->delete();
        }
        $emp = Employer::find($pending->user_id);

        // Mail
        $sub = "Your gig has been approved";
        $message="<p>Dear {$emp->name},</p><p>Your gig, {$pending->campaign_title}, has been approved by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));

        $pending->delete();
        Session()->flash('success','Gig Approved');
        return redirect()->back();
    }
    public function rejectCampaign($id){
        PendingTask::where('cid',$id)->delete();
        $pending = PendingGig::find($id);
        PendingGig::find($id)->delete();
        $emp = Employer::find($pending->user_id);

        // Mail
        $sub = "Your gig has been rejected";
        $message="<p>Dear {$emp->name},</p><p>Your gig, {$pending->campaign_title}, has been rejected by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($emp->email)->send(new GlobalMail($data));
        Session()->flash('success','Gig Deleted');
        return redirect()->back();
    }

    // Create Gigs

    public function createGig(){
        $campaignCategory = GigCategory::get();
        return view('manager.pages.createGig')->with([
            'campaignCategory' => $campaignCategory
        ]);
    }
    public function storeGig(Request $request){

        //validation
        $this->validate($request, [
            'cat' => 'required',
            'per_cost' => 'required|numeric',
            'description' => 'required',
            'campaign_title' => 'required',
            'brand' => 'required',
            'tasks' => 'required',
            'filess' => 'required',
            'logo' => 'required|image',
        ]);
        $campaign = new Gig();
        $campaign->per_cost = $request->per_cost;
        $campaign->campaign_title = $request->campaign_title;
        $campaign->description = $request->description;
        $cat = "";
        foreach($request->cat as $cate){
            $cat = $cate.", ".$cat;
        }
        $campaign->cats = $cat;
        $campaign->brand = $request->brand;
        if($request->hasFile('logo')){
            $name = $_FILES['logo']['name'];
            $tmp = $_FILES['logo']['tmp_name'];
            $path = "assets/admin/img/gig-brand-logo/";
            $name = "Gig_Brand_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $campaign->logo = $name;
            }
            else{
                $request->session()->flash('error', 'There is some problem in uploading the image');
                return redirect()->back();
            }
        }
        $campaign->user_id = "Admin";
        $campaign->save();
        $i=0;

        foreach($request->tasks as $taske){
            $files[$i]= "<a href=\"".$request->filess[$i]."\" class=\"btn btn-link\">Click here to download the file(s)</a>";
            $taske = $taske."<br/>".$files[$i];
            $task = new Task;
            $task->cid = $campaign->id;
            $task->task = $taske;
            $task->save();
            $i++;
        }

        //redirect
        Session()->flash('success', 'Your gig successfully created');
        return redirect()->back();
    }
}
