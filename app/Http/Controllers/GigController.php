<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gig;
use App\GigCategory as CC;
use App\CompletedGig as CJ;
use App\GigApp as GA;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GigController extends Controller
{
    public function list(){
        $campaigns = Gig::orderBy('created_at','desc')->paginate(15);
        $cats = CC::get();
        return view('gigs.list')->with([
            'campaigns' => $campaigns,
            'cats' => $cats,
        ]);
    }
    public function details($id){
        $campaign = Gig::find($id);
        return view("gigs.details")->with([
            'campaign' => $campaign,
        ]);
    }
    public function apply(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        if(!Auth::check()){
            Session()->flash('warning','Please login as a user to apply for this job');
            return redirect()->back();
        }
        if(GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->exists()){
            Session()->flash('warning','You have already applied for the mission');
            return redirect()->back();
        }
        else{
            $job = new GA;
            $job->uid = Auth::user()->id;
            $job->cid = $request->id;
            $job->save();
            Session()->flash('success','Applied for the gig. Wait for the creator to approve it.');
            return redirect()->back();
        }
    }
    public function cats($id){
        $campaigns = Gig::where('campaign_category',$id)->orderBy('created_at','desc')->paginate(15);
        $cats = CC::get();
        return view('gigs.cat')->with([
            'campaigns' => $campaigns,
            'cats' => $cats,
        ]);
    }

    public function prooffb(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'username' => 'required',
            'link' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        $text = "Username: ".$request->username.", Post Link: ".$request->link.", Type: Facebook";
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_FB_".$request->id."_user_".$request->username."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }

    public function proofwa(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'phone' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        $text = "Phone: ".$request->phone.", Type: Whatsapp";
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_WA_".$request->id."_user_".$request->phone."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }

    public function proofinsta(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'username' => 'required',
            'link' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        $text = "Username: ".$request->username.", Post Link: ".$request->link.", Type: Instagram Story";
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_Insta_".$request->id."_user_".$request->username."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }

    public function proofyt(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'username' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        $text = "Username: ".$request->username.", Type: Youtube";
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_Youtube_".$request->id."_user_".$request->username."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }

    public function proofinstap(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'username' => 'required',
            'link' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        $text = "Username: ".$request->username.", Post Link: ".$request->link.", Screenshot: ".$request->ss.", Type: Instagram Post";
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_Insta_".$request->id."_user_".$request->username."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }

    public function proofos(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'email' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        $text = "Email: ".$request->email.", Screenshot: ".$request->ss.", Type: Online Survey";
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_OS_".$request->id."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }
    
    
    
    
    public function proofar(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'cred' => 'required',
            'ss' => 'required|image',
        ]);
        $cj = new CJ;
        if($request->hasFile('ss')){
            $name = $_FILES['ss']['name'];
            $tmp = $_FILES['ss']['tmp_name'];
            $path = "assets/user/images/proof_file/";
            $name = "Proof_AR_".$request->id."_".$name;
            if(move_uploaded_file($tmp,$path.$name)){
                $cj->proof_file = $name;
            }
            else{
                $request->session()->flash('error', "Cannot upload screenshot. Try again.");
                return redirect()->back();
            }
        }
        $text = "Credentials: ".$request->cred." Type: Download App";
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }
    
    public function proofls(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'cred' => 'required',
        ]);
        $cj = new CJ;
        $text = "Credentials: ".$request->cred.", Type: Social Media";
        $cj->proof_text = $text;
        $cj->job_id = $request->id;
        $cj->user_id = Auth::user()->id;
        $cj->status==0;
        $cj->save();
        $ga = GA::where(['uid' => Auth::user()->id,'cid' => $request->id])->first();
        $ga->status = 3;
        $ga->save();
        $request->session()->flash('success', "Proof Submitted");
        return redirect()->back();
    }
}
