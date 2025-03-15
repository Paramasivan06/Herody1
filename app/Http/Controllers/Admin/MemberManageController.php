<?php

namespace App\Http\Controllers\Admin;

use App\Gig;
use App\User;
use App\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use App\CampaignApp;
use App\ProjectApps;
use App\GigApp;
use Excel;
use App\Exports\GigAppStatusExport;
use DB;
use App\Transition;
use App\Exports\AllUsers;
use App\Exports\RefReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class MemberManageController extends Controller
{
    public function ShowAllMember(Request $request)
{
    $filterId = $request->input('filter_id');
    $filterEmail = $request->input('filter_email'); // Assuming email filter
    $filterPhone = $request->input('filter_phone');
    
    $query = User::orderBy('created_at', 'desc');
    
    if ($filterId || $filterEmail || $filterPhone) {
        $query->where(function($q) use ($filterId, $filterEmail, $filterPhone) {
            if ($filterId) {
                $q->where('id', $filterId); // Filter by id
            }

            if ($filterEmail) {
                $q->orWhere('email', 'like', '%' . $filterEmail . '%'); // Filter by email
            }

            if ($filterPhone) {
                $q->orWhere('phone', 'like', '%' . $filterPhone . '%'); // Filter by phone
            }
        });
    }
    
    $users = $query->paginate(50);
    $serials = $users->firstItem();
    
    return view('admin.member.all_member', compact('users', 'serials'));
}

    public function updateBalance(Request $request)
        {
            // Validate the input
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'balance' => 'required|numeric|min:0',
            ]);
        
            // Find the user by ID
            $user = User::find($request->user_id);
        
            if ($user) {
                // Update the balance
                $user->balance = $request->balance;
                $user->save();
        
                // Redirect back with a success message
                return redirect()->route('admin.member.all')->with('success', 'Balance updated successfully.');
            }
        
            // If user not found, return with an error message
            return redirect()->route('admin.member.all')->with('error', 'User not found.');
        }

    public function MemberisBlocked(Request $request)
    {
        $user = User::find($request->id);
        $user->isBlocked = $request->isBlocked;
        $user->save();
        return redirect()->back()->with('success', 'User blocked status updated successfully.');
    }

    public function ShowMemberDetails($id)
    {
        $userById = User::findOrFail($id);
        return view('admin.member.view_member',compact('userById'));
    }

    public function MemberUpdate(Request $request)
    {
         $user = User::findOrFail($request->id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->state = $request->state;
        $user->address = $request->address;
        $user->zip_code = $request->zip_code;
        $user->account_status = $request->account_status;


        //image update
        if ($request->hasFile('profile_photo')) {

            //delete old image
            $path = 'assets/user/images/user_profile/';
            $location = $path . $user->profile_photo;
            if (! is_null($user->profile_photo)){
                unlink($location);
            }


            //upload new image
            $input_image = Image::make($request->profile_photo);
            $image = $input_image->resize(224, 235);
            $image_name = $request->file('profile_photo')->getClientOriginalName();
            $image_name = Carbon::now()->format('YmdHs') . '_' . $image_name;
            $image->save($path . $image_name);

            //image update
            $user->profile_photo = $image_name;
        }

        $user->save();

        //redirect
        Session()->flash('success', 'successfully updated!');
        return redirect()->back();
    }

    //CampaignReport
    public function CampaignReport($id)
    {
        $acampaigns = CampaignApp::where('uid',$id)->orderBy('updated_at','desc')->paginate(20);
        return view('admin.member.campaign_report',compact('acampaigns'));
    }
    
    //WithdrawReport
    public function WithdrawReport($uid)
    {
        $transitions = Transition::where('uid', $uid)->orderBy('updated_at','desc')->paginate(20);
        return view('admin.member.withdraw_report', compact('transitions'));
    }

     //Project Report
    public function projectReport($uid)
    {
        $aprojects = ProjectApps::where('uid',$uid)->orderBy('updated_at','desc')->paginate(20);
        return view('admin.member.project_report',compact('aprojects'));
    }

    //Gig Report
    public function gigReport($uid)
    {
        $agigs = GigApp::where('uid',$uid)->orderBy('updated_at','desc')->paginate(20);
        return view('admin.member.gig_report',compact('agigs'));
    }

    public function pending(){
        $users = User::where('app_status',0)->orderBy('updated_at','asc')->paginate(15);
        return view('admin.member.pending_regs')->with([
            'users' => $users,
        ]);
    }
    public function approve($id){
        $user = User::find($id);
        $user->app_status = 1;
        $user->save();
        Session()->flash('success','Approved User');
        return redirect()->back();
    }
    public function reject($id){
        User::find($id)->delete();
        Session()->flash('success','User Deleted');
        return redirect()->back();
    }
    public function excel_export(){
        $users = User::get();
        if($users->count()==0){
            Session()->flash('warning','No user found');
            return redirect()->back();
        }
        else{
            return Excel::download(new AllUsers(), 'users.xlsx');
        }
    }
    public function excel_referrals(){
        $users = User::get();
        if($users->count()==0){
            Session()->flash('warning','No user found');
            return redirect()->back();
        }
        else{
            return Excel::download(new RefReport(), 'ref_report.xlsx');
        }
    }
    public function memberDelete(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        User::find($request->id)->delete();
        $request->session()->flash('success', 'Deleted Successfully');
        return redirect()->back();
    }
    public function create(){
        
        return view("admin.member.create")->with([
           
        ]);
    }
    public function store(Request $request){
        $user = new User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->state = $request->state;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->zip_code = $request->zip_code;
        $user->account_status = $request->account_status;
        $user->password = Hash::make($request->password);
        $emailCheck = User::where('email',$request->email)->first();
        if($emailCheck){
            Session()->flash('warning', 'email already exist');
            return redirect()->back()->withInput();
        }
        $userphone = User::where('phone',$request->phone)->first();
        if($userphone){
            Session()->flash('warning', 'mobile already exist!');
            return redirect()->back()->withInput();
        }

        //image update
        if ($request->hasFile('profile_photo')) {

            //delete old image
            $path = 'assets/user/images/user_profile/';

            //upload new image
            $input_image = Image::make($request->profile_photo);
            $image = $input_image->resize(224, 235);
            $image_name = $request->file('profile_photo')->getClientOriginalName();
            $image_name = Carbon::now()->format('YmdHs') . '_' . $image_name;
            $image->save($path . $image_name);
            $user->profile_photo = $image_name;
        }

        $user->save();

        //redirect
        Session()->flash('success', 'successfully Created!');
        return redirect()->back();
    }
    
    public function exportGigAppStatus()
{
    return Excel::download(new GigAppStatusExport, 'gig_app_status_4.xlsx');
}

}
