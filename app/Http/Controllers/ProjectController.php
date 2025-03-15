<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ProjectApps as JA;
use App\Employer;
use App\JobProof;
use App\Question as Qs;
use App\QAnswer as QA;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    public function list(){
        $job = Project::orderBy('updated_at','desc')->paginate(30);
        $cats = [
            "SALES & BUSINESS DEVELOPMENT",
            "PRODUCTION",
            "MAINTENANCE",
            "ACCOUNTING AND FINANCE",
            "ADMIN & HUMAN RESAURCES (HR) MANAGEMENT",
            "PROCUREMENT & PLANNING",
            "TESTING & QUALITY",
            "RESEARCH & DEVELOPMENT (R & D)",
            "DESIGN",
            "MARKETING",
            "TRAINING & DEVELOPMENT",
            "PURCHASING",
            "SUPPLY CHAIN MANAGEMENT",
            "INVENTORY & STORE",
            "IT & ITES",
            "ENVIRONMENTAL HEALTH AND SAFETY",
            "CORPORATE SUPPORT",
            "ENGINEERING",
            "ELECTRICAL",
            "MECHANICAL",
            "FACILITY MANAGEMENT",
            "CUSTOMER SERVICE SUPPORT",
            "CONSULTANT",
            "EXPERT",
            "CONTRACTOR",
            "OTHER",
        ];
        return view('projects.list')->with([
            'jobs' => $job,
            'cats' => $cats,
        ]);
    }
    public function details($id){
        $job = Project::find($id);
        if($job==NULL){
            Session()->flash('error','The Job Does not exist');
            return redirect()->back();
        }
        $questions = QS::where('pid',$id)->get();
        $emp = Employer::find($job->user);
        return view('projects.details')->with([
            'job' => $job,
            'emp' => $emp,
            'questions' => $questions,
        ]);
    }
    public function apply(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'answer' => 'required',
        ]);
        $id = $request->id;
        if(!Auth::check()){
            Session()->flash('warning','Please login as a user to apply for this job');
            return redirect()->back();
        }
        $job = Project::find($id);
        if($job==NULL){
            Session()->flash('error','The Job Does not exist');
            return redirect()->back();
        }
        if(JA::where(['uid' => Auth::user()->id,'jid' => $id])->exists()){
            Session()->flash('warning','You have already applied for the project');
            return redirect()->back();
        }
        if(JA::where('jid',$id)->get()->count()>=$job->count){
            Session()->flash('error','Application limit for this project has exceeded. Try applying for the other projects');
            return redirect()->back();
        }
        $job = new JA;
        $job->uid = Auth::user()->id;
        $job->jid = $id;
        $job->status = 0;
        $job->save();
        $qs = Qs::select('id')->where('pid',$request->id)->pluck('id');
        $i = 0;
        $ans = $request->answer;
        foreach($ans as $an){
            $qa = new QA;
            $qa->uid = Auth::user()->id;
            $qa->qid = $qs[$i];
            $qa->answer = $an;
            $qa->save();
            $i = $i+1;
        }
        Session()->flash('success','Applied for the job');
        return redirect()->back();
    }
    public function loc(Request $request){
        $this->validate($request,[
            'location' => 'required'
        ]);
        if($request->location=="All"){
            return redirect('jobs');
        }
        else{
            $job = Project::where('place',$request->location)->orderBy('updated_at','desc')->paginate(30);
        }
        return view('projects.list')->with([
            'jobs' => $job,
            'loc' => $request->location,
        ]);
    }
    public function cat(Request $request){
        $this->validate($request,[
            'cat' => 'required'
        ]);
        if($request->cat=="All"){
            return redirect('projects');
        }
        else{
            $job = Project::where('cat',$request->cat)->orderBy('updated_at','desc')->paginate(30);
        }
        $cats = [
            "SALES & BUSINESS DEVELOPMENT",
            "PRODUCTION",
            "MAINTENANCE",
            "ACCOUNTING AND FINANCE",
            "ADMIN & HUMAN RESAURCES (HR) MANAGEMENT",
            "PROCUREMENT & PLANNING",
            "TESTING & QUALITY",
            "RESEARCH & DEVELOPMENT (R & D)",
            "DESIGN",
            "MARKETING",
            "TRAINING & DEVELOPMENT",
            "PURCHASING",
            "SUPPLY CHAIN MANAGEMENT",
            "INVENTORY & STORE",
            "IT & ITES",
            "ENVIRONMENTAL HEALTH AND SAFETY",
            "CORPORATE SUPPORT",
            "ENGINEERING",
            "ELECTRICAL",
            "MECHANICAL",
            "FACILITY MANAGEMENT",
            "CUSTOMER SERVICE SUPPORT",
            "CONSULTANT",
            "EXPERT",
            "CONTRACTOR",
            "OTHER",
        ];
        return view('projects.list')->with([
            'jobs' => $job,
            'cats' => $cats,
        ]);
    }

    public function proofs(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        $job = Project::find($request->id);
        $user = Auth::user();
        if(JobProof::where(['uid' => $user->id,'jid' => $job->id])->exists()){
            $request->session()->flash('error', "Proof already submited");
            return redirect()->back();
        }
        $jp = new JobProof;
        $jp->uid = $user->id;
        $jp->jid = $job->id;
        $jp->proof = "Proof:";
        $proofs = explode(',',$job->proofs);
        if(in_array('Link',$proofs)){
            $this->validate($request,[
                'link' => 'required',
            ]);
            $jp->proof = $jp->proof." Link: ".$request->link;
        }
        if(in_array('File',$proofs)){
            $this->validate($request,[
                'file' => 'required',
            ]);
            if($request->hasFile('file')){
                $path = "assets/user/images/jobproof_files/";
                $name = $_FILES['file']['name'];
                $tmp = $_FILES['file']['tmp_name'];
                $name = "Proof_".$user->id."_".$name;
                if(move_uploaded_file($tmp,$path.$name)){
                    $asset = asset('assets/user/images/jobproof_files/'.$name);
                    $jp->proof = $jp->proof." <br/> File: <a href=\"".$asset."\">Click here to view the file</a>";
                }
            }
        }
        if(in_array('Image',$proofs)){
            if($request->hasFile('image')){
                $path = "assets/user/images/jobproof_images/";
                $name = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                $name = "Proof_".$user->id."_".$name;
                if(move_uploaded_file($tmp,$path.$name)){
                    $asset = asset('assets/user/images/jobproof_images/'.$name);
                    $jp->proof = $jp->proof." <br/> Image: <a href=\"".$asset."\">Click here to view the image</a>";
                }
            }
        }
        $jp->save();
        $ja = JA::where(['jid'=> $job->id, 'uid' => $user->id])->first();
        $ja->status = 4;
        $ja->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }
}
