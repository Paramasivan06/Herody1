<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\CampaignApp;
use Illuminate\Support\Facades\Auth;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class CampaignController extends Controller
{
    public function list(){
        $campaigns = Campaign::latest('created_at')->paginate(9);
        return view('campaigns.list')->with([
            'campaigns' => $campaigns,
        ]);
    }
    public function details($id){
        $campaign = Campaign::find($id);
        return view('campaigns.details')->with([
            'campaign' => $campaign,
        ]);
    }
    public function apply(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'terms' => 'required',
        ]);
        if(!Auth::check()){
            Session()->flash('warning','Please login as a user to apply for this job');
            return redirect()->back();
        }
        $campaignn = Campaign::find($request->id);
        if(CampaignApp::where('cid',$request->id)->get()->count()>=$campaignn->ucount){
            $request->session()->flash('error', 'Maximum application limit has exceeded for this campaign. Try applying for other campaigns.');
            return redirect()->back();
        }
        else{
            $campaign = new CampaignApp;
            $campaign->cid = $request->id;
            $campaign->uid = Auth::user()->id;
            $campaign->status = 0;
            $campaign->save();
            $request->session()->flash('success', 'Applied');
            return redirect()->back();
        }
    }

    public function responser(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        if(CampaignApp::where(['cid'=>$request->id,'uid' => Auth::user()->id,'status'=>1])->exists()){
            $ca = CampaignApp::where(['cid'=>$request->id,'uid' => Auth::user()->id,'status'=>1])->first();
            $campaign = Campaign::find($request->id);
            $form = Form::find($campaign->form);
    
            $pageTitle = "{$form->name}";
    
            return view('campaigns.response', compact('form', 'pageTitle','ca'));
        }
        else{
            $request->session()->flash('warning', "You are not allowed to submit the responses");
            return redirect()->back();
        }
    }

    public function responsera($id,$uid){
        Auth::loginUsingId($uid);
        if(CampaignApp::where(['cid'=>$id,'uid' => $uid,'status'=>1])->exists()){
            $ca = CampaignApp::where(['cid'=>$id,'uid' => $uid,'status'=>1])->first();
            $campaign = Campaign::find($id);
            $form = Form::find($campaign->form);
    
            $pageTitle = "{$form->name}";
    
            return view('campaigns.response', compact('form', 'pageTitle','ca'));
        }
        else{
            Session::flash('warning', "You are not allowed to submit the responses");
            return redirect()->back();
        }
    }
    public function response(Request $request, $id,$cid)
    {
        $form = Form::find($id);

        DB::beginTransaction();

        try {
            $input = $request->except('_token');

            // check if files were uploaded and process them
            $uploadedFiles = $request->allFiles();
            foreach ($uploadedFiles as $key => $file) {
                // store the file and set it's path to the value of the key holding it
                if ($file->isValid()) {
                    $input[$key] = $file->store('fb_uploads', 'public');
                }
            }

            $user_id = auth()->user()->id;

            $form->submissions()->create([
                'user_id' => $user_id,
                'content' => $input,
            ]);

            DB::commit();
            $campaign = CampaignApp::find($cid);
            $campaign->status = 3;
            $campaign->save();
            $request->session()->flash('success', "Form submitted successfully");
            return redirect()->route('mission.details',$campaign->cid);
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return back()->withInput()->with('error', Helper::wtf());
        }
    }
}
