<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Skill;
use App\Education;
use App\Experiences;
use App\UserProject;
use App\Select;
use App\Reject;
use App\Shortlisted;
use App\Project;
use App\ProjectApps;
use App\CompletedGig;
use App\GigApp as GA;
use Carbon\Carbon;
use App\Withdraw;
use App\Banner;
use App\WithdrawRequest;
use App\Transition;
use App\Gig;
use App\Campaign;
use App\Employer;
use App\CampaignApp;

class DetailController extends Controller
{
    public function details(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $user = User::find($request->id);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            return response()->json(['response'=>['code'=>'SUCCESS','user' => $user]], 200);
        }
    }
    public function skills(Request $request){
        $this->validate($request,[
            'uid' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $skills = Skill::where('uid',$user->id)->get();
            return response()->json(['response'=>['code'=>'SUCCESS','user'=>$user,'skills'=>$skills,'count'=>$skills->count()]], 200);
        }
    }
    public function exp(Request $request){
        $this->validate($request,[
            'uid' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $exps = Experiences::where('uid',$user->id)->get();
            return response()->json(['response'=>['code'=>'SUCCESS','user'=>$user,'exps'=>$exps,'count'=>$exps->count()]], 200);
        }
    }

    public function edu(Request $request){
        $this->validate($request,[
            'uid' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $edus = Education::where('uid',$user->id)->get();
            return response()->json(['response'=>['code'=>'SUCCESS','user'=>$user,'edus'=>$edus,'count'=>$edus->count()]], 200);
        }
    }
    public function projects(Request $request){
        $this->validate($request,[
            'uid' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $projects = UserProject::where('uid',$user->id)->get();
            return response()->json(['response'=>['code'=>'SUCCESS','user'=>$user,'projects'=>$projects,'count'=>$projects->count()]], 200);
        }
    }

    
    public function hobbyUpdate(Request $request){
        $this->validate($request,[
            'uid'=>'required',
            'hobby' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $user->hobbies = $request->hobby;
            $user->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function achUpdate(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'ach' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $user->achievements = $request->ach;
            $user->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function socialUpdate(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'fb' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'github' => 'nullable',
            'insta' => 'nullable',
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $user->fb = $request->fb;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->github = $request->github;
            $user->insta = $request->insta;
            $user->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }

    public function eduUpdate(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'type' => "required",
            'name' => "required",
            'course' => "required",
            'start' => "required",
            'end' => "required",
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $edu = new Education;
            $edu->type = $request->type;
            $edu->name = $request->name;
            $edu->course = $request->course;
            $edu->start = $request->start;
            $edu->end = $request->end;
            $edu->uid = $request->uid;
            $edu->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function expUpdate(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'company' => "required",
            'designation' => "required",
            'des' => "required",
            'start' => "required",
            'end' => "required",
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $exp = new Experiences;
            $exp->company = $request->company;
            $exp->designation = $request->designation;
            $exp->des = $request->des;
            $exp->start = $request->start;
            $exp->end = $request->end;
            $exp->uid = $request->uid;
            $exp->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function projectsUpdate(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'title' => "required",
            'projdes' => "required",
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $proj = new UserProject;
            $proj->title = $request->title;
            $proj->des = $request->projdes;
            $proj->uid = $request->uid;
            $proj->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function skillsUpdate(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'name' => "required",
            'rating' => "required",
        ]);
        $user = User::find($request->uid);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER DOES NOT EXIST']], 401);
        }
        else{
            $skill = new Skill;
            $skill->name = $request->name;
            $skill->rating = $request->rating;
            $skill->uid = $request->uid;
            $skill->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }

    public function eduDelete(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $edu = Education::find($request->id);
        if($edu==NULL){
            return response()->json(['response'=>['code'=>'THIS ENTRY DOES NOT EXIST']], 401);
        }
        else{
            $edu->delete();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function expDelete(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $exp = Experiences::find($request->id);
        if($exp==NULL){
            return response()->json(['response'=>['code'=>'THIS ENTRY DOES NOT EXIST']], 401);
        }
        else{
            $exp->delete();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function projectsDelete(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $project = UserProject::find($request->id);
        if($project==NULL){
            return response()->json(['response'=>['code'=>'THIS ENTRY DOES NOT EXIST']], 401);
        }
        else{
            $project->delete();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }
    public function skillsDelete(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $skill = Skill::find($request->id);
        if($skill==NULL){
            return response()->json(['response'=>['code'=>'THIS ENTRY DOES NOT EXIST']], 401);
        }
        else{
            $skill->delete();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }

    
    public function jprojects(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $user = User::find($request->id);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
        }
        else{
            $projects = ProjectApps::where('uid', $request->id)->get();
            $aprojs = array();
            foreach($projects as $project){
                $uproj = Project::find($project->jid);
                $euser=Employer::find($uproj->user);
           $uproj->image=asset('assets/employer/profile_images/'.$euser->profile_photo);
           $uproj->brand=$euser->cname;
                $aprojs[] = $uproj;
            }
            return response()->json(['response'=>['code'=>'SUCCESS','projects' => $projects,'projectsinfo'=>$aprojs]], 200);
        }
    }
    public function gigs(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $user = User::find($request->id);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
        }
        else{
            $gigs = GA::where('uid', $request->id)->get();
            $agigs = array();
            foreach($gigs as $gig){
                $ugig = Gig::find($gig->cid);
                $agigs[] = $ugig;
            }
            return response()->json(['response'=>['code'=>'SUCCESS','gigs' => $gigs,'gigsinfo'=>$agigs]], 200);
        }
    }

    public function campaigns(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $user = User::find($request->id);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
        }
        else{
            $campaigns = CampaignApp::where('uid', $request->id)->get();
            $acampaigns = array();
            foreach($campaigns as $campaign){
                $ucamp = Campaign::find($campaign->cid);
                $acampaigns[] = $ucamp;
            }
            return response()->json(['response'=>['code'=>'SUCCESS','campaigns' => $campaigns,'campaigninfo'=>$acampaigns]], 200);
        }
    }
    public function profileUpdate(Request $request){

        //validation
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'zip_code' => 'required',
        ]);

        $user = User::find($request->id);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
        }
        else{
            $user->name = $request->name;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->address = $request->address;

            $user->phone = $request->phone;
            $user->zip_code = $request->zip_code;


            $user->save();
            return response()->json(['response'=>['code'=>'SUCCESS']], 200);
        }
    }

    public function passUpdate(Request $request)
    {
        //validation
        $this->validate($request, [
            'id' => 'required',
            'current_password' => 'required',
            'password' => 'required'
        ]);
        $user = User::find($request->id);
        if($user==NULL){
            return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
        }
        else{
            $UserPassword = $user->password;
            if (password_verify($request->current_password, $UserPassword)) {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['response'=>['code'=>'SUCCESS']], 200);
            } 
            else {
                return response()->json(['response'=>['code'=>'CURRENT PASSWORD IS INCORRECT']], 401);
            }
        }
    }

    // Withdraws

    public function withdrawMethod(){
        $withdrawMethods = Withdraw::get();
        return response()->json(['response'=>['code'=>'SUCCESS','method'=>$withdrawMethods,'count'=>$withdrawMethods->count()]], 200);
    }
    
    // Banners
    public function bannerMethod(){
        $bannerMethods = Banner::get();
        return response()->json(['response'=>['code'=>'SUCCESS','prop'=>$bannerMethods,'count'=>$bannerMethods->count()]], 200);
    }
    
    //  public function withdraw(Request $request){
    //     $this->validate($request,[
    //         'uid' => 'required',
    //         'amount' => 'required',
    //         'method_id' => 'required',
    //         'details' => 'required',
    //     ]);
    //     $user = User::find($request->uid);
    //     if($user!=NULL){
    //         if($user->balance<$request->amount){
    //             return response()->json(['response'=>['code'=>'USER BALANCE IS NOT SUFFICIENT']], 401);
    //         }
    //         else{
    //             $user_balance = $user->balance;
    //             $user_balance -=$request->amount;
    //             User::where('id', $user->id)->update(['balance' => $user_balance]);

    //             $withdrawRequest = new WithdrawRequest();
    //             $withdrawRequest->withdraw_method_id = $request->method_id;
    //             $withdrawRequest->user_id = $request->uid;
    //             $withdrawRequest->payment_details = $request->details;
    //             $withdrawRequest->payable_amount = $request->amount;

    //             $withdrawRequest->save();

    //             $tr = new Transition;
    //             $tr->uid = $request->uid;
    //             $tr->reason = "Withdrawal";
    //             $tr->transition = "-".$request->amount;
    //             $tr->balance = $user_balance;
    //             $tr->save();
    //             return response()->json(['response'=>['code'=>'SUCCESS']], 200);
    //         }
    //     }
    //     else{
    //         return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
    //     }
    //  }
    public function withdraw(Request $request)
{
    $this->validate($request, [
        'uid' => 'required',
        'amount' => 'required',
        'method_id' => 'required',
        'details' => 'required',
    ]);

    $user = User::find($request->uid);

    if ($user != null) {
        if ($user->balance < $request->amount) {
            return response()->json(['response' => ['code' => 'USER BALANCE IS NOT SUFFICIENT']], 401);
        } else {
            // Get the user's current balance
            $previous_balance = $user->balance;

            // Deduct the withdrawal amount
            $user_balance = $previous_balance - $request->amount;

            // Update the user's balance in the user table
            $user->update(['balance' => $user_balance]);

            // Create a new withdrawal request
            $withdrawRequest = new WithdrawRequest();
            $withdrawRequest->withdraw_method_id = $request->method_id;
            $withdrawRequest->user_id = $request->uid;
            $withdrawRequest->payment_details = $request->details;
            $withdrawRequest->payable_amount = $request->amount;
            $withdrawRequest->save();

            // Save the transaction details, including the previous and updated balances
            $tr = new Transition();
            $tr->uid = $request->uid;
            $tr->reason = "Withdrawal";
            $tr->transition = "-" . $request->amount;
            $tr->pbalance = $previous_balance; // Store the previous balance
            $tr->balance = $user_balance; // Store the updated balance
            $tr->save();

            return response()->json(['response' => ['code' => 'SUCCESS']], 200);
        }
    } else {
        return response()->json(['response' => ['code' => 'USER NOT FOUND']], 401);
    }
}

// public function withdraw(Request $request)
// {
//     $this->validate($request, [
//         'uid' => 'required',
//         'amount' => 'required|numeric',
//         'method_id' => 'required',
//         'details' => 'required',
//     ]);

//     $user = User::find($request->uid);

//     if ($user !== null) {
//         // Check if user has sufficient balance
//         if ($user->balance < $request->amount) {
//             return response()->json(['response' => ['code' => 'USER BALANCE IS NOT SUFFICIENT']], 401);
//         }

//         $user_balance = $user->balance;
//         $user_balance -= $request->amount;
//         User::where('id', $user->id)->update(['balance' => $user_balance]);

//         $withdrawRequest = new WithdrawRequest();
//         $withdrawRequest->withdraw_method_id = $request->method_id;
//         $withdrawRequest->user_id = $request->uid;
//         $withdrawRequest->payment_details = $request->details;
//         $withdrawRequest->payable_amount = $request->amount;
//         $withdrawRequest->status = 0; // Initially set status as pending
//         $withdrawRequest->save();

//         // Now, process the payout
//         $body = [
//             'amount'           => $withdrawRequest->payable_amount,
//             'account_number'   => $withdrawRequest->account_number,
//             'payment_mode'     => 'UPI',
//             'reference_id'     => 'TXN-WD-' . uniqid('', true),
//             'transcation_note' => 'Herody Rewards',
//             'beneficiaryName'  => $withdrawRequest->user->name,
//             'ifsc'             => $withdrawRequest->ifsc,
//             'upi'              => $withdrawRequest->payment_details,
            
//         ];

//         $curl = curl_init();
//         curl_setopt_array($curl, [
//             CURLOPT_URL => 'https://api.bulkpe.in/client/initiatepayout',
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_ENCODING => '',
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => 'POST',
//             CURLOPT_POSTFIELDS => json_encode($body),
//             CURLOPT_HTTPHEADER => [
//                 'Content-Type: application/json',
//                 'Authorization: Bearer aWSVQNyt+z3IiJHV+YX9Urfeu3k9ovB8ItygeQojyce1LVb0GjKXMeHVBjQEPctUfmsnfTq/vXasRuN3suskauPRo429ihzDfneb331mAj2ZqjuVYEONkmSLAZLOyIlml1dnlN3cbwPLQ+3++jHk3A==',
//             ],
//         ]);

//         $response = curl_exec($curl);
//         curl_close($curl);

//         $responseData = json_decode($response, true);

//         // Check for success based on the response message
//         if (isset($responseData['status']) && $responseData['status'] === true && $responseData['data']['message'] === 'Transaction Initiated!') {
//             $withdrawRequest->status = 1; // Update status to success
//             $withdrawRequest->save();

//             // Add a transition record
//             $tr = new Transition();
//             $tr->uid = $request->uid;
//             $tr->reason = "Withdrawal";
//             $tr->transition = "-" . $request->amount;
//             $tr->save();

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Withdrawal and payout processed successfully',
//                 'response' => $responseData,
//             ]);
//         } else {
//             // Rollback user balance if payout fails
//             $user_balance += $withdrawRequest->payable_amount;
//             User::where('id', $user->id)->update(['balance' => $user_balance]);

//             return response()->json([
//                 'status' => 'failure',
//                 'message' => 'Payout processing failed',
//                 'response' => $responseData,
//             ], 400);
//         }
//     } else {
//         return response()->json(['response' => ['code' => 'USER NOT FOUND']], 401);
//     }
// }


    public function transactions(Request $request){
        $this->validate($request,[
            'uid' => 'required',
        ]);
        $user = User::find($request->uid);
        if($user!=NULL){
            $trs = Transition::where('uid',$request->uid)->get();
            return response()->json(['response'=>['code'=>'SUCCESS','transactions'=>$trs]], 200);
        }
        else{
            return response()->json(['response'=>['code'=>'USER NOT FOUND']], 401);
        }
    }

    // Profile Photo update API
    public function profileImage(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'profile_photo' => 'required',
        ]);
        
        $user = User::find($request->id);
        $path = 'assets/user/images/user_profile/';
        $img = $request->profile_photo;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = uniqid() . '.png';
        $file = $path . $name;
        $success = file_put_contents($file, $data);
        $user->profile_photo = $name;
        $user->save();
        
        return $success?response()->json(['response'=>['code'=>'SUCCESS']], 200):response()->json(['response'=>['code'=>'UNSUCCESS']], 401);
    }

    public function allTransactions(Request $request){
        $user = User::find($request->id);
        $refs = User::where('ref_by',$user->ref_code)->get();
        // For referrals
        $radds = Transition::where('uid',$request->id)->where('reason','LIKE','%Referral Bonus%')->get();
        $data['referrals'] = [];
        $data['gigs'] = [];
        $data['projects'] = [];
        $data['campaigns'] = [];
        $data['referred'] = $refs->count();
        if($radds->count()==0){
            $ra = 0;
        }
        else{
            $ra = 0;
            foreach($radds as $radd){
                $ra = $ra + $radd->addm;
                array_push($data['referrals'],$radd);
            }
        }
        // For gigs
        $gadds = Transition::where('uid',$request->id)->where('reason','LIKE','%Gig%')->get();
        if($gadds->count()==0){
            $ga = 0;
        }
        else{
            $ga = 0;
            foreach($gadds as $gadd){
                $ga = $ga + $gadd->addm;
                array_push($data['gigs'],$gadd);
            }
        }
        // For projects
        $padds = Transition::where('uid',$request->id)->where('reason','LIKE','%Project%')->get();
        if($padds->count()==0){
            $pa = 0;
        }
        else{
            $pa = 0;
            foreach($padds as $padd){
                $pa = $pa + $padd->addm;
                array_push($data['projects'],$padd);
            }
        }
        // For campaigns
        $cadds = Transition::where('uid',$request->id)->where('reason','LIKE','%Campaign%')->get();
        if($cadds->count()==0){
            $ca = 0;
        }
        else{
            $ca = 0;
            foreach($cadds as $cadd){
                $ca = $ca + $cadd->addm;
                array_push($data['campaigns'],$cadd);
            }
        }
        // For Telecallings
        
        return response()->json(['response'=>['code'=>'SUCCESS','referralEarnings'=>$ra,'gigEarnings'=>$ga,'projectEarnings'=>$pa,'campaignEarnings'=>$ca,'referred'=>$refs->count(),'user_balance'=>$user->balance,'data'=>$data]], 200);
    }
    public function storeRef(Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'ref' => 'required'
        ]);
        $user = User::find($request->uid);
        if($user->ref_by == NULL){
            $refu = User::where('ref_code',$request->ref)->first();
            if($refu == NULL){
                return response()->json(['response'=>['code'=>'ERROR','message'=>'The referral code does not exist']], 401);
            }
            else{
                $user->ref_by = $refu->id;
                return response()->json(['response'=>['code'=>'SUCCESS']], 200);
            }
        }
        else{
            return response()->json(['response'=>['code'=>'ERROR','message'=>'The user is already referred by someone else']], 401);
        }
    }
    
//   public function updateReward(Request $request)
//  {
//     // Validate incoming request data
//     $validated = $request->validate([
//         'user_id' => 'required|integer|exists:users,id',
//         'reward_points' => 'required|integer|min:0',
//     ]);

//     // Find the user by ID
//     $user = User::findOrFail($validated['user_id']);

//     // Increment the reward points field by the new value
//     $user->reward_points += $validated['reward_points'];
    
//     // Increment the balance field by the new value
//     $user->balance += $validated['reward_points'];

//     // Save the updated user data
//     $user->save();
        

//     // Return a success response
//     return response()->json([
//         'message' => 'Reward points and balance updated successfully',
//         'reward_points' => $user->reward_points,
//         'balance' => $user->balance,
//     ], 200);
    
// }
public function updateReward(Request $request)
{
    // Validate incoming request data
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'reward_points' => 'required|integer|min:0',
    ]);

    // Find the user by ID
    $user = User::findOrFail($validated['user_id']);

    // Increment the reward points and balance fields by the new value
    $rewardPoints = $validated['reward_points'];
    $user->reward_points += $rewardPoints;
    $user->balance += $rewardPoints;

    // Save the updated user data
    $user->save();

    // Save transaction for referral bonus or reward update
    $transaction = new Transition();
    $transaction->uid = $user->id; // User ID
    $transaction->reason = "Rewards From Spin";
    $transaction->transition = "+{$rewardPoints}";
    $transaction->addm = $rewardPoints; // Additional reward points
    $transaction->save();

    // Return a success response
    return response()->json([
        'message' => 'Reward points and balance updated successfully',
        'reward_points' => $user->reward_points,
        'balance' => $user->balance,
    ], 200);
}

 public function getSpinCount($user_id)
    {
        // Find the user by ID
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the user's spin_count
        return response()->json([
            'message' => 'Spin count fetched successfully',
            'user_id' => $user->id,
            'spin_count' => $user->spin_count,
        ], 200);
    }
 public function decrementSpinCount(Request $request)
    {
        // Validate the user ID or get it from authenticated user
        $userId = $request->input('user_id'); // For example, sent via POST request
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if spin_count is greater than 0 before decrementing
        if ($user->spin_count > 0) {
            $user->decrement('spin_count');
            return response()->json(['message' => 'Spin count decremented', 'spin_count' => $user->spin_count], 200);
        }

        // Return error if spin_count is already 0
        return response()->json(['message' => 'No spins left', 'spin_count' => $user->spin_count], 400);
    }
    // public function show($id)
    // {
    //     // Fetch the withdrawal record by ID
    //     $withdrawal = WithdrawRequest::find($id);

    //     if (!$withdrawal) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Withdrawal record not found',
    //         ], 404);
    //     }

    //     // Return the withdrawal details, including the 'status' field
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'id' => $withdrawal->id,
    //             'withdraw_method_id' => $withdrawal->withdraw_method_id,
    //             'user_id' => $withdrawal->user_id,
    //             'payment_details' => $withdrawal->payment_details,
    //             'payable_amount' => $withdrawal->payable_amount,
    //             'status' => $withdrawal->status,
    //             'reference_id' => $withdrawal->reference_id,
    //             'created_at' => $withdrawal->created_at,
    //             'updated_at' => $withdrawal->updated_at,
    //         ],
    //     ]);
    // }
    public function showByUserId($user_id)
    {
        // Fetch withdrawal records for the given user_id
        $withdrawals = WithdrawRequest::where('user_id', $user_id)->get();

        if ($withdrawals->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No withdrawal records found for this user',
            ], 404);
        }

        // Return the withdrawal details, including the 'status' field
        return response()->json([
            'status' => 'success',
            'data' => $withdrawals->map(function ($withdrawal) {
                return [
                    'id' => $withdrawal->id,
                    'withdraw_method_id' => $withdrawal->withdraw_method_id,
                    'user_id' => $withdrawal->user_id,
                    'payment_details' => $withdrawal->payment_details,
                    'payable_amount' => $withdrawal->payable_amount,
                    'status' => $withdrawal->status,
                    'reference_id' => $withdrawal->reference_id,
                    'created_at' => $withdrawal->created_at,
                    'updated_at' => $withdrawal->updated_at,
                ];
            }),
        ]);
    }
}
