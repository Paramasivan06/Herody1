<?php

namespace App\Http\Controllers\Admin;

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
use Excel;
use GuzzleHttp\Client;
use App\Exports\AllCampaigns;
use App\Exports\CampaignApps;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;

class MissionController extends Controller
{
    public function index(){
        $missions = Campaign::paginate(15);
        return view('admin.mission.index')->with([
            'missions' =>$missions,
        ]);
    }
    public function creater(){
        return view('admin.mission.create');
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
        $cities = $request->city;
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
        return view('admin.mission.form')->with([
            'id' =>$campaign->id,
            'form_roles' => $form_roles,
        ]);
    }
    public function addform($id){
        $form_roles = Helper::getConfiguredRoles();
        $campaign = CampaignApp::find($id);
        return view('admin.mission.form')->with([
            'id' =>$campaign->id,
            'form_roles' => $form_roles,
        ]);
    }
    public function storeForm(SaveFormRequest $request){
        
        $id = Auth::guard('admin')->id();

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
        if($camp->form){
        $subs = Submission::where('form_id',$camp->form)->delete();
        Form::find($camp->form)->delete();
    }
        $camp->delete();
        $request->session()->flash('success', "Project Deleted Successfully");
        return redirect()->back();
    }
    
    // Active or Inactive
    public function projectStatus($id)
    {
        $campaign = Campaign::find($id);
    
        if ($campaign) {
            // Toggle the gigstatus
            $campaign->campaignstatus = !$campaign->campaignstatus;
            $campaign->save();
        }
    
        return back();
    }

    // Applications
    public function applications($id)
    {
        // Fetch campaign applications with user data
        $campaigns = CampaignApp::where('cid', $id)->with('user')->latest()->paginate(100);

        // Debugging: Check if data exists
        if ($campaigns->isEmpty()) {
            return back()->with('error', 'No applications found for this campaign.');
        }

        return view('admin.mission.applications', [
            'campaigns' => $campaigns,
            'campid' => $id,
        ]);
    }

    
    public function accept($id){
        $campaign = CampaignApp::find($id);
        $campaign->status = 1;
        $campaign->save();
        $job = Campaign::find($campaign->cid);
        $user = User::find($campaign->uid);
        
        
        // $client = new \GuzzleHttp\Client();
                                            
        // $response = $client->request('POST', 'https://fcm.googleapis.com/v1/projects/herody-bf512/messages:send', [
        //     'body' => '{message: {token:' .$user->rigistration_token. ',priority: "high",data: {title: "Title Test",body: "This is body text"}}}',
        //     'headers' => [
        //     'content-type' => 'application/json',
        //     ],
        // ]);
        
        // Mail
         
        session()->flash('success', "Application accepted");
        return redirect()->back();
    }
    public function reject($id){
        $campaign = CampaignApp::find($id);
        $campaign->status = 2;
        $campaign->save();
        $job = Campaign::find($campaign->cid);
        $user = User::find($campaign->uid);
        
        // $client = new \GuzzleHttp\Client();
                                            
        // $response = $client->request('POST', 'https://fcm.googleapis.com/v1/projects/herody-bf512/messages:send', [
        //     'body' => '{message: {token:' .$user->rigistration_token. ',priority: "high",data: {title: "Title Test",body: "This is body text"}}}',
        //     'headers' => [
        //     'content-type' => 'application/json',
        //     ],
        // ]);
        
        // Mail
        
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

        return view('admin.mission.responses', compact('submission', 'pageTitle', 'form_headers','camp'));
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
       
        $request->session()->flash('error', "Response rejected");
        return redirect()->route('admin.mission.applications',$campaign->id);
    }
    public function export_excel(){
        $campaigns = Campaign::get();
        if($campaigns->count()==0){
            Session()->flash('warning','No campaign found');
            return redirect()->back();
        }
        else{
            return Excel::download(new AllCampaigns(), 'campaigns.xlsx');
        }
    }
    public function export_apps($id){
        $gigs = Campaign::find($id);
        if($gigs==NULL){
            Session()->flash('warning','No campaign found');
            return redirect()->back();
        }
        else{
            return Excel::download(new CampaignApps($id), 'campaignapps.xlsx');
        }
    }

    public function editform(Request $request){

        $form = Form::find($request->id);

        $pageTitle = 'Edit Form';

        $saveURL = route('admin.mission.updateform', $form);

        // get the roles to use to populate the make the 'Access' section of the form builder work
        $form_roles = Helper::getConfiguredRoles();

        return view('admin.mission.editform', compact('form', 'pageTitle', 'saveURL', 'form_roles'));
    }
    public function updateform(SaveFormRequest $request, $id)
    {
        $user = auth()->user();
        $form = Form::find($id);

        $input = $request->except('_token');

        if ($form->update($input)) {
            // dispatch the event
            event(new FormUpdated($form));

            return response()
                    ->json([
                        'success' => true,
                        'details' => 'Form successfully updated!',
                        'dest' => route('admin.missions'),
                    ]);
        } else {
            response()->json(['success' => false, 'details' => 'Failed to update the form.']);
        }
    }
    public function makeMobile(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $campaign = Campaign::find($request->id);
        $campaign->mobile = 1;
        $campaign->save();
        $request->session()->flash('success', "The campaign has been made mobile specific");
        return redirect()->back();
    }
    public function undoMobile(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $campaign = Campaign::find($request->id);
        $campaign->mobile = 0;
        $campaign->save();
        $request->session()->flash('success', "The campaign has been removed from mobile specific");
        return redirect()->back();
    }
    public function EditProject($id){
        $campaign = Campaign::find($id);
        return view('admin.mission.edit_project')->with([
            'campaign' => $campaign
        ]);
    }
    
    function UpdateProject(Request $request,$id){
        $this->validate($request,[
            'reward' => 'required|numeric',
            'des' => 'required',
            'title' => 'required',
            'ucount'=> 'required',
        ]);
        $campaign = Campaign::find($id);
        $campaign->title = $request->title;
        $campaign->des = $request->des;
        $campaign->reward = $request->reward;
        $campaign->ucount = $request->ucount;
        $campaign->save();
        $request->session()->flash('success', "Project edited successfully");
        return redirect()->back();
    }
}
