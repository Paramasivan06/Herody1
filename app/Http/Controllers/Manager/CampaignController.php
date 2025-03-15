<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Campaign;
use jazmy\FormBuilder\Events\Form\FormCreated;
use jazmy\FormBuilder\Events\Form\FormDeleted;
use jazmy\FormBuilder\Events\Form\FormUpdated;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Requests\SaveFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\CampaignApp;
use jazmy\FormBuilder\Models\Submission;
use App\User;
use App\Transition;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function index(){
        $missions = Campaign::paginate(15);
        return view('manager.mission.index')->with([
            'missions' =>$missions,
        ]);
    }
    public function creater(){
        return view('manager.mission.create');
    }
    public function create(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'des' => 'required',
            'brand' => 'required',
            'logo' => 'required|image',
            'start' => 'required',
            'before' => 'required',
            'end' => 'required',
            'ucount' => 'required',
            'city' => 'required',
            'reward' => 'required',
            'benefits' => 'required',
            'requirements' => 'required',
            'imp_terms' => 'required',
            'terms' => 'required',
            'dondont' => 'required',
            'instructions' => 'required',
            'methods' => 'required',
        ]);
        $campaign = new Campaign;
        $campaign->title = $request->title;
        $campaign->des = $request->des;
        $campaign->brand = $request->brand;
        if($request->hasFile('logo')){
            $path = "assets/admin/img/camp-brand-logo/";
            $name = $_FILES['logo']['name'];
            $temp = $_FILES['logo']['tmp_name'];
            $name = "Logo_".$request->brand."_".$name;
            if(move_uploaded_file($temp,$path.$name)){
                $campaign->logo = $name;
            }
            else{
                $request->session()->flash('error', "Error in uploading the file");
                return redirect()->back();
            }
        }
        $cities = "";
        foreach($request->city as $city){
            $cities = $city.",".$cities;
        }
        $campaign->start = $request->start;
        $campaign->before = $request->before;
        $campaign->end = $request->end;
        $campaign->ucount = $request->ucount;
        $campaign->city = $cities;
        $campaign->reward = $request->reward;
        $campaign->benefits = $request->benefits;
        $campaign->requirements = $request->requirements;
        $campaign->imp_terms = $request->imp_terms;
        $campaign->terms = $request->terms;
        $campaign->dondont = $request->dondont;
        $campaign->instructions = $request->instructions;
        $campaign->methods = $request->methods;
        $campaign->save();
        $form_roles = Helper::getConfiguredRoles();
        return view('manager.mission.form')->with([
            'id' =>$campaign->id,
            'form_roles' => $form_roles,
        ]);
    }
    public function storeForm(SaveFormRequest $request){
        
        $id = Auth::guard('manager')->id();

        $input = $request->merge(['user_id' => $id])->except('_token');

        DB::beginTransaction();

        // generate a random identifier
        $input['identifier'] = $id.'-'.Helper::randomString(20);
        $created = Form::create($input);

        try {
            // dispatch the event
            event(new FormCreated($created));

            DB::commit();
            $f = Form::latest('id')->first();
            $campaign = Campaign::find($request->campid);
            $campaign->form = $f->id;
            $campaign->save();
            return response()->json(['success' => true, 'details' => 'Successfully created']);

        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return response()->json(['success' => false, 'details' => 'Failed to create the form.']);
        }
    }

    // Delete the campaign
    public function delete(Request $request){
        $camp = Campaign::find($request->id);
        $subs = Submission::where('form_id',$camp->form)->delete();
        Form::find($camp->form)->delete();
        $camp->delete();
        $request->session()->flash('success', "Campaign Deleted Successfully");
        return redirect()->back();
    }

    // Applications
    public function applications($id){
        $campaigns = CampaignApp::where('cid',$id)->latest()->paginate(15);
        return view('manager.mission.applications')->with([
            'campaigns' => $campaigns,
        ]);
    }
    public function accept($id){
        $campaign = CampaignApp::find($id);
        $campaign->status = 1;
        $campaign->save();
        $job = Campaign::find($campaign->cid);
        $user = User::find($campaign->uid);
        
        // Mail
        $sub = "Your campaign application has been accepted";
        $message="<p>Dear {$user->name},</p><p>Your application for, {$job->title}, has been accepted by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        session()->flash('success', "Application accepted");
        return redirect()->back();
    }
    public function reject($id){
        $campaign = CampaignApp::find($id);
        $campaign->status = 2;
        $campaign->save();
        $job = Campaign::find($campaign->cid);
        $user = User::find($campaign->uid);
        
        // Mail
        $sub = "Your campaign application has been rejected";
        $message="<p>Dear {$user->name},</p><p>Your application for, {$job->title}, has been rejected by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));
        
        session()->flash('success', "Application rejected");
        return redirect()->back();
    }
    public function response($id){
        $camp = CampaignApp::find($id);
        $campaign = Campaign::find($camp->cid);
        $submission = Submission::where(['user_id' => $camp->uid, 'form_id' => $campaign->form])
                            ->with('form')
                            ->firstOrFail();

        $form_headers = $submission->form->getEntriesHeader();

        $pageTitle = "View Submission";

        return view('manager.mission.responses', compact('submission', 'pageTitle', 'form_headers','camp'));
    }
    public function acceptResp(Request $request){
        $this->validate($request,[
            'reward'=>'required',
        ]);
        $camp = CampaignApp::find($request->id);
        $campaign = Campaign::find($camp->cid);
        $camp->status = 4;
        $camp->save();
        $user = User::find($camp->uid);
        $user->balance = $user->balance + $request->reward;
        $user->save();
        $tr = new Transition;
        $tr->transition = "+".$request->reward;
        $tr->reason = "Campaign Reward";
        $tr->uid = $user->id;
        $tr->addm = $request->reward;
        $tr->save();
        if($user->ref_by!=NULL):
            $userr = User::find($user->ref_by);
            $userr->balance = $userr->balance+($request->reward*0.5);
            $userr->save();
            $tr = new Transition;
            $tr->uid = $userr->id;
            $tr->reason = "Referral Bonus";
            $tr->transition = "+".($request->reward*0.5);
            $tr->addm = ($request->reward*0.5);
            $tr->save();
        endif;
        
        // Mail
        $sub = "Your campaign response has been accepted";
        $message="<p>Dear {$user->name},</p><p>Your response for, {$campaign->title}, has been accepted by an admin.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $request->session()->flash('success', "Response accepted");
        return redirect()->back();
    }
    public function rejectResp(Request $request){
        $camp = CampaignApp::find($request->id);
        $campaign = Campaign::find($camp->cid);
        Submission::where(['user_id' => $camp->uid, 'form_id' => $campaign->form])->delete();
        $job = Campaign::find($camp->cid);
        $user = User::find($camp->uid);
        $camp->status = 5;
        $camp->save();
        
        // Mail
        $sub = "Your campaign response has been rejected";
        $message="<p>Dear {$user->name},</p><p>Your response for, {$job->title}, has been rejected by a manager.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $request->session()->flash('error', "Response rejected");
        return redirect()->route('manager.mission.applications',$campaign->id);
    }
}
