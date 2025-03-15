<?php

namespace App\Http\Controllers\Admin;

use App\Gig;
use App\GigCategory;
use App\CompletedGig as CJ;
use App\IncompletedGig as IG;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Employer;
use App\PendingGig;
use App\GigApp as GA;
use App\Task;
use App\DeletedGig;
use App\PendingTask;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use App\Transition;
use Excel;
use App\Exports\GigProofs;
use App\Exports\RejectProofs;
use App\Exports\AllGigs;
use App\Exports\GigApps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    // public function ShowAllCampaign()
    // {
    //     $campaigns = Gig::orderBy('created_at','desc')->paginate(50);
    //     return view('admin.campaign.all_campaign',compact('campaigns'));
    // }
    public function ShowAllCampaign()
{
    $campaigns = Gig::orderBy('gigstatus', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(50);
    return view('admin.campaign.all_campaign', compact('campaigns'));
}

    public function BackupGig()
    {
        $backups = DeletedGig::orderBy('created_at','desc')->paginate(50);
        return view('admin.campaign.backup_gigs',compact('backups'));
    }
    public function details($id)
    {
        $gig = Gig::find($id);
        return view('admin.campaign.details',compact('gig'));
    }
    

    public function statusCampaign($id)
    {
        $gig = Gig::find($id);
    
        if (!$gig) {
            return back()->with('error', 'Gig not found');
        }
    
        // Toggle gigstatus and save
        $gig->gigstatus = !$gig->gigstatus;
        $gig->save();
    
        return back()->with('success', 'Status updated successfully!');
    }
    
    
    
    public function toggleShowStatus($id)
    {
        $gig = Gig::find($id);
    
        if ($gig) {
            // Toggle the status: 0 -> 1 -> 2 -> 0
            $newStatus = ($gig->show_status + 1) % 4; // Cycle through 0, 1, 2
            $gig->show_status = $newStatus;
            $gig->save();
        }
    
        return back();
    }
     public function toggleViewStatus($id)
    {
        $gig = Gig::findOrFail($id);
    
        // If view_status is null, set it to 0 (default)
        if (is_null($gig->view_status)) {
            $gig->view_status = 0;
        }
    
        // Toggle the view_status between 0 and 1
        $gig->view_status = $gig->view_status == 1 ? 0 : 1;
    
        $gig->save();
    
        return redirect()->back()->with('success', 'View status updated successfully!');
    }

    public function ShowCampaignLog()
    {
        $campaigns = Gig::paginate(15);
        return view('admin.campaign.campaign_log',compact('campaigns'));
    }

    public function CreateCampaign(){
        $campaignCategory = GigCategory::get();
        return view('admin.campaign.create_campaign',compact('campaignCategory'));
    }

    public function StoreCampaign(Request $request)
    {

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
    public function Campaignapp($id){
        $apps = GA::where('cid',$id)->orderBy('created_at','desc')->paginate(15);
        return view('admin.campaign.campaign_app')->with([
            'campaigns' => $apps,
        ]);
    }
    public function pendings(){
        $campaigns = PendingGig::orderBy('created_at','asc')->paginate(15);
        return view('admin.campaign.pendings',compact('campaigns'));
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
        $campaign->timing = $pending->timing;
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

        $pending->delete();
        $emp = Employer::find($campaign->user_id);

        // Mail
        
        Session()->flash('success','Gig Approved');
        return redirect()->back();
    }
    public function rejectCampaign($id){
        PendingTask::where('cid',$id)->delete();
        $campaign = PendingGig::find($id);
        PendingGig::find($id)->delete();
        $emp = Employer::find($campaign->user_id);

        // Mail
        
        Session()->flash('success','Gig Deleted');
        return redirect()->back();
    }
    public function Campaignapprove($jid,$uid){
        $app = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $app->status=1;
        $app->save();
        Session()->flash('success','Application Approved');
        return redirect()->back();
    }
    public function Campaignreject($jid,$uid){
        $app = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $app->status=2;
        $app->save();
        Session()->flash('success','Application Rejected');
        return redirect()->back();
    }
    public function viewproof($jid,$uid){
        $apps = CJ::where(['job_id'=>$jid,'user_id'=>$uid])->get();
        return view('admin.campaign.view_proofs')->with([
            'campaigns' => $apps,
        ]);
    }
    public function acceptproof($jid,$uid){
        $ga = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $job = Gig::find($jid);
        $ga->status = 4;
        $ga->save();
        $user = User::find($uid);
        $user->balance = $user->balance + $job->per_cost;
        $user->save();
        $tr = new Transition;
        $tr->uid = $user->id;
        $tr->reason = "For completing Gig ".$job->campaign_title;
        $tr->transition = "+".$job->per_cost;
        $tr->addm = $job->per_cost;
        $tr->save();
        if($user->ref_by!=NULL){
            $user = User::find($user->ref_by);
            $c = 0.05*$job->per_cost;
            $user->balance = $user->balance + $c;
            $user->save();
            $tr = new Transition;
            $tr->uid = $user->id;
            $tr->reason = "Referral Bonus";
            $tr->transition = "+".$c;
            $tr->addm = $c;
            $tr->save();
        }
        Session()->flash('success', "Accepted");
        return redirect()->back();
    }
    public function rejectproof($jid,$uid){
        $ga = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $job = Gig::find($jid);
        $ga->status = 5;
        $ga->save();
        $jobs = CJ::where(['job_id'=>$jid,'user_id'=>$uid])->get();
        $path = "assets/user/images/proof_file/";
        foreach($jobs as $job){
            if($job->proof_file!=NULL){
                unlink($path.$job->proof_file);
            }
            $job->delete();
        }
        Session()->flash('success', "Rejected");
        return redirect()->back();
    }
    public function export_excel(){
        $gigs = Gig::get();
        if($gigs->count()==0){
            Session()->flash('warning','No gig found');
            return redirect()->back();
        }
        else{
            return Excel::download(new AllGigs(), 'gigs.xlsx');
        }
    }
    public function export_apps($id){
        $gigs = Gig::find($id);
        if($gigs==NULL){
            Session()->flash('warning','No gig found');
            return redirect()->back();
        }
        else{
            return Excel::download(new GigApps($id), 'gigsapps.xlsx');
        }
    }
    public function makeMobile(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $gig = Gig::find($request->id);
        $gig->mobile = 1;
        $gig->save();
        $request->session()->flash('success', "The gig has been made mobile specific");
        return redirect()->back();
    }
    public function undoMobile(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $gig = Gig::find($request->id);
        $gig->mobile = 0;
        $gig->save();
        $request->session()->flash('success', "The gig has been removed from mobile specific");
        return redirect()->back();
    }
    public function DeleteCampaign(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
    
        // Get the gig before deleting
        $gig = Gig::find($request->id);
    
        // Store the deleted gig details in the deleted_gigs table
        DeletedGig::create([
            'id' => $gig->id,
            'per_cost' => $gig->per_cost,
            'campaign_title' => $gig->campaign_title,
            'description' => $gig->description,
            'brand' => $gig->brand,
            'user_id' => $gig->user_id,
            // Add other fields you want to store
        ]);
    
        // Soft delete the gig
        $gig->delete();
    
        $request->session()->flash('success', 'Deleted Successfully');
        return redirect()->back();
        // $this->validate($request,[
        //     'id' => 'required',
        // ]);
        // Gig::find($request->id)->delete();
        // $request->session()->flash('success', 'Deleted Successfully');
        // return redirect()->back();
    }
    public function DeleteBackupCampaign(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        DeletedGig::find($request->id)->delete();
        $request->session()->flash('success', 'Backup Gig Deleted Successfully');
        return redirect()->back();
    }
    
    public function export_excel_for_backup($id){
        
        $job = DeletedGig::find($id);
        // dd($job->user_id);
        // dd($em);
        if($job==NULL){
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
        if($job->user_id ){
            $proofs = CJ::where(['job_id' => $id])->get();
            if($proofs->count()==0){
                Session()->flash('warning','No proof found');
                return redirect()->back();
            }
            else{
                $campaignTitle = $job->campaign_title; 
                $fileName = $campaignTitle . ' backup_accepted_proofs.xlsx';
                return Excel::download(new GigProofs($id, $campaignTitle), $fileName);
                // return Excel::download(new GigProofs($id), 'proofs.xlsx');
            }
        }
        else{
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
    }
    
    public function export_reject_excel_for_backup($id){
        // $em = Employer::find(Auth::guard('employer')->id());
        $job = DeletedGig::find($id);
        
        if($job==NULL){
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
        if($job->user_id){
            $proofs = IG::where(['job_id' => $id])->get();
            if($proofs->count()==0){
                Session()->flash('warning','No proof found');
                return redirect()->back();
            }
            else{
                $campaignTitle = $job->campaign_title; 
                $fileName = $campaignTitle . ' backup_rejected_proofs.xlsx';
                return Excel::download(new RejectProofs($id, $campaignTitle), $fileName);
                // return Excel::download(new RejectProofs($id), 'rejectproofs.xlsx');
            }
        }
        else{
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
    }
    
    
    public function EditCampaign($id){
        $campaignCategory = GigCategory::get();
        $gig = Gig::find($id);
        return view('admin.campaign.edit_campaign')->with([
            'campaignCategory' => $campaignCategory,
            'gig' => $gig
        ]);
    }

    function UpdateCampaign(Request $request,$id){
        $this->validate($request,[
            'per_cost' => 'required|numeric',
            'description' => 'required',
            'campaign_title' => 'required',
            'timing' => 'nullable|numeric', 

        ]);
        $gig = Gig::find($id);
        $gig->campaign_title = $request->campaign_title;
        $gig->description = $request->description;
        $gig->per_cost = $request->per_cost;
        $gig->timing = $request->input('timing');
        $gig->save();
        $request->session()->flash('success', "Gig edited successfully");
        return redirect()->back();
        
    }
    public function setPriority(Request $request)
    {
        $campaign = Gig::findOrFail($request->id);
        $campaign->priority = $request->priority;
        $campaign->save();
    
        return redirect()->back()->with('success', 'Priority set successfully');
    }
    public function toggleShowFirst(Request $request, $id)
{
    // Validate the slot number
    $request->validate([
        'set_slot' => 'required|integer|min:0',
    ]);

    $newSlot = $request->input('set_slot');

    // Reset old slot numbers if the same slot is already assigned
    Gig::where('set_slot', $newSlot)->update(['set_slot' => 0]);

    // Update the selected gig with the new slot number
    $gig = Gig::findOrFail($id);
    $gig->set_slot = $newSlot;
    $gig->save();

    return redirect()->back()->with('success', 'Slot number set successfully.');
}
public function toggleShowSecond(Request $request, $id)
{
    // Validate the second slot number
    $request->validate([
        'second_slot' => 'required|integer|min:0',
    ]);

    $newSlot = $request->input('second_slot');

    // Reset old slot numbers if the same slot is already assigned
    Gig::where('second_slot', $newSlot)->update(['second_slot' => 0]);

    // Update the selected gig with the new slot number
    $gig = Gig::findOrFail($id);
    $gig->second_slot = $newSlot;
    $gig->save();

    return redirect()->back()->with('success', 'Second slot number set successfully.');
}

}
