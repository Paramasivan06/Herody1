<?php

namespace App\Http\Controllers\Employer;

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
use App\Employer;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function index(){
        $emp = Employer::find(Auth::guard('employer')->id());
        $missions = Campaign::where('brand',$emp->cname)->paginate(15);
        return view('employer.campaigns.index')->with([
            'missions' =>$missions,
        ]);
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
        $campaigns = CampaignApp::where('cid',$id)->latest()->paginate(100);
        return view('employer.campaigns.applications')->with([
            'campaigns' => $campaigns,
        ]);
    }
    public function accept($id){
        $campaign = CampaignApp::find($id);
        $campaign->status = 1;
        $campaign->save();
        $job = Campaign::find($campaign->cid);
        $user = User::find($campaign->uid);

        $user->balance = $user->balance + $job->per_cost;
        $user->save();
        $tr = new Transition;
        $tr->uid = $user->id;
        $tr->reason = "For completing Gig ".$job->campaign_title;
        $tr->transition = "+".$job->per_cost;
        $tr->addm = $job->per_cost;
        $tr->save();
        var_dump($user->ref_by);
        if($user->ref_by!=NULL){
            $userr = User::where(['ref_code'=>$user->ref_by])->first();
            // var_dump($userr);die();
            $c = 0.05*$job->per_cost;
            $userr->balance = $userr->balance + $c;
            $userr->save();
            $tr = new Transition;
            $tr->uid = $userr->id;
            $tr->reason = "Referral Bonus";
            $tr->transition = "+".$c;
            $tr->addm = $c;
            $tr->save();
        }
        
        // Mails
        // $subject = 'Application Accepted';
        // $message = "<p>Dear {$user->name},</p><p>We congratulate you on your selection in {$job->title}.</p>";
        // $data = array('sub'=>$subject,'message'=>$message);
        // Mail::to($user->email)->send(new GlobalMail($data));
       
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

        return view('employer.campaigns.responses', compact('submission', 'pageTitle', 'form_headers','camp'));
    }
    // public function acceptResp(Request $request){
    //     $this->validate($request,[
    //         'reward'=>'required',
    //     ]);
    //     $camp = CampaignApp::find($request->id);
    //     $campaign = Campaign::find($camp->cid);
    //     $camp->status = 4;
    //     $camp->save();
    //     $user = User::find($camp->uid);
    //     $user->balance = $user->balance + $request->reward;
    //     $user->save();
    //     $tr = new Transition;
    //     $tr->transition = "+".$request->reward;
    //     $tr->reason = "Campaign Reward";
    //     $tr->uid = $user->id;
    //     $tr->addm = $request->reward;
    //     $tr->save();
    //     if($user->ref_by!=NULL):
    //         $userr = User::find($user->ref_by);
    //         $userr->balance = $userr->balance+($request->reward*0.5);
    //         $userr->save();
    //         $tr = new Transition;
    //         $tr->uid = $userr->id;
    //         $tr->reason = "Referral Bonus";
    //         $tr->transition = "+".($request->reward*0.5);
    //         $tr->addm = ($request->reward*0.5);
    //         $tr->save();
    //     endif;
        
    //     // Mail
        
    //     $request->session()->flash('success', "Response accepted");
    //     return redirect()->back();
    // }
    
    public function acceptResp(Request $request)
{
    $this->validate($request, [
        'reward' => 'required',
    ]);

    $camp = CampaignApp::find($request->id);
    $campaign = Campaign::find($camp->cid);

    // Update campaign application status
    $camp->status = 4;
    $camp->save();

    // Update user balance
    $user = User::find($camp->uid);
    $user->balance += $request->reward;
    $user->completed_tasks += 1; // Increment completed tasks count
    $user->save();

    // Log transaction for user
    $tr = new Transition;
    $tr->transition = "+" . $request->reward;
    $tr->reason = "Campaign Reward";
    $tr->uid = $user->id;
    $tr->addm = $request->reward;
    $tr->save();

    // Handle referral bonus
    // if ($user->ref_by != NULL) {
    //     $referrer = User::find($user->ref_by);

    //     // Calculate referral bonus (50% of the reward)
    //     $referralBonus = $request->reward * 0.5;

    //     // Update referrer's balance
    //     $referrer->balance += $referralBonus;
    //     $referrer->save();

    //     // Log transaction for referrer
    //     $tr = new Transition;
    //     $tr->uid = $referrer->id;
    //     $tr->reason = "Referral Bonus";
    //     $tr->transition = "+" . $referralBonus;
    //     $tr->addm = $referralBonus;
    //     $tr->save();
    // }
if ($user->ref_by != NULL) {
    // Find the referrer using 'ref_by' (assumes it contains the referrer's ID)
    $referrer = User::find($user->ref_by);

    if ($referrer) {
        // Apply 50% bonus only if the user has completed 3 or fewer tasks
        $bonusPercentage = $user->completed_tasks <= 2 ? 0.5 : 0;

        if ($bonusPercentage > 0) {
            // Calculate referral bonus
            $referralBonus = $request->reward * $bonusPercentage;

            // Update the referrer's balance
            $referrer->balance += $referralBonus;
            $referrer->save();

            // Log the transaction for the referrer
            $tr = new Transition;
            $tr->uid = $referrer->id;
            $tr->reason = "Referral Bonus";
            $tr->transition = "+" . $referralBonus;
            $tr->addm = $referralBonus;
            $tr->save();
        }
    }
}


    // Send success response
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
        
      
        $request->session()->flash('error', "Response rejected");
        return redirect()->route('employer.mission.applications',$campaign->id);
    }
}
