<?php

namespace App\Http\Controllers\Employer;
// use App\Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Task;
use App\PendingTask;
use App\GigCategory;
use App\Gig;
use App\PendingGig;
use App\CompletedGig as CJ;
use App\IncompletedGig as IG;
use Illuminate\Support\Facades\Session;
use App\User;
use App\DeletedGig;
use App\GigApp as GA;
use App\Employer;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use App\Transition;
use App\Exports\GigProofs;
use App\Exports\RejectProofs;
use App\Exports\EmGigsApps;
use Excel;
use GuzzleHttp\Client;
use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;


use App\Services\FirebaseService;

class GigController extends Controller
{
    public function manage()
    {
        $campaigns = Gig::where('user_id',Auth::guard('employer')->id())->orderBy('created_at','desc')->paginate(15);
        return view('employer.gigs.manage',compact('campaigns'));
    }
    public function creater(){
        $emp = Employer::find(Auth::guard('employer')->id());
        $campaignCategory = GigCategory::get();
        return view('employer.gigs.create')->with([
            'employer' => $emp,
            'campaignCategory' => $campaignCategory,
        ]);
    }
    public function create(Request $request){
        $this->validate($request, [
            'cat' => 'required',
            'per_cost' => 'required|numeric',
            'description' => 'required',
            'campaign_title' => 'required',
            'filess'=>'required',
            'tasks' => 'required',
            'timing' => 'nullable|numeric',

        ]);
        $emp = Employer::find(Auth::guard('employer')->id());
        $campaign = new PendingGig;
        $campaign->per_cost = $request->per_cost;
        $campaign->campaign_title = $request->campaign_title;
        $campaign->description = $request->description;
        $cat = "";
        foreach($request->cat as $cate){
            $cat = $cate.", ".$cat;
        }
        $campaign->cats = $cat;
        $campaign->brand = $emp->cname;
        $campaign->logo = $emp->profile_photo;
        $campaign->timing = $request->timing;
        $campaign->user_id = Auth::guard('employer')->id();
        $campaign->save();
        $i=0;

        foreach($request->tasks as $taske){
            $files[$i]= "<a href=\"".$request->filess[$i]."\" class=\"btn btn-link\">Click here to download the file(s)</a>";
            $taske = $taske."<br/>".$files[$i];
            $task = new PendingTask;
            $task->cid = $campaign->id;
            $task->task = $taske;
            $task->save();
            $i++;
        }

        
        //redirect
        Session()->flash('success', 'Your gig is successfully created. Wait for the admin to approve it.');
        return redirect()->back();
    }


   public function applications($id)
    {
        $gig = Gig::findOrFail($id);
    
        // Get all applications for the given gig
        $apps = GA::where('cid', $id)->orderBy('created_at', 'desc')->paginate(100);
    
        // Count total applicants
        $totalApplicants = GA::where('cid', $id)->count();
        $gig->total_applicants = $totalApplicants;
    
        // Count applicants with status = 4
        $approvedApplicants = GA::where('cid', $id)->where('status', 4)->count();
        $gig->approved_applicants = $approvedApplicants;
    
        // Save the updated counts to the database
        $gig->save();
    
        // Pass the approvedApplicants count to the view
        return view('employer.gigs.applications', [
            'gig' => $gig,
            'campaigns' => $apps,
            'approvedApplicants' => $approvedApplicants, // Pass the count here
        ]);
    }
    
    public function delete(Request $request){
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
    
        $request->session()->flash('success', 'Gig Deleted Successfully');
        return redirect()->back();
    }

    // public function approveApp($jid,$uid){
    //     $app = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
    //     $app->status=1;
    //     $app->save();
    //     $gig = Gig::find($jid);
    //     $user = User::find($uid);

    //     // Mails
    //     if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    //         $subject = 'Application Approved';
    //         $message = "<p>Dear {$user->name},</p><p>We congratulate you on your selection in {$gig->campaign_title}.</p>";
    //         $data = array('sub' => $subject, 'message' => $message);
    
    //         try {
    //             Mail::to($user->email)->send(new GlobalMail($data));
    //         } catch (\Exception $e) {
    //         // Log the error message
    //         \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
    //         // Collect invalid email
    //             $invalidEmails[] = $user->email;
    //         }
    //     }else {
    //         $invalidEmails[] = $user->email;
    //     }
        
    //     // Check if there were any invalid emails
    //     if (!empty($invalidEmails)) {
    //         session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
    //     } else {
    //          Session()->flash('success','Application Approved');
    //     }
    //     return redirect()->back();
    // }
    
    
    
    
    // public function approveApp($jid,$uid){
    //     GA::where(['cid'=>$jid,'uid'=>$uid])->update(['status' => 1]);
    //     $gig = Gig::find($jid);
    //     $user = User::find($uid);
        
    //     // print_r($user);
    //     // exit;
    
    //     // $client = new \GuzzleHttp\Client();
                                            
    //     // $response = $client->request('POST', 'https://fcm.googleapis.com/v1/projects/herody-bf512/messages:send', [
    //     //     'body' => '{message: {token:' .$user->rigistration_token. ',priority: "high",data: {title: "Title Test",body: "This is body text"}}}',
    //     //     'headers' => [
    //     //     'content-type' => 'application/json',
    //     //     ],
    //     // ]);
        
        
    //     // Mail
        
    //     // $subject = 'Gig Approval Message';
    //     // $message = "<p>Dear {$user->name},</p><p>We congratulate you on your selection in {$gig->campaign_title}.</p>";
    //     // $data = array('sub'=>$subject,'message'=>$message);
    //     // Mail::to($user->email)->send(new GlobalMail($data));
        
    //     Session()->flash('success','Application Approved');
    //     return redirect()->back();
    // }
    
    
    
      public function approveApp($jid, $uid)
    {
        $app = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $app->status=1;
        $app->save();
        $gig = Gig::find($jid);
        $user = User::find($uid);
        
       
        // $firebaseService = new FirebaseService();

        // $message = [
        //     'message' => [
        //         'token' => $user->rigistration_token, 
        //         'notification' => [
        //             'title' => 'Application Approved',
        //             'body' => 'Your application has been approved.'
        //         ],
               
        //     ],
        // ];
      
        // $firebaseService->sendMessage($message);
        
        // Mails
        if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $subject = 'Application Approved';
            $message = "<p>Dear {$user->name},</p><p>We congratulate you on your selection in {$gig->campaign_title}.</p>";
            $data = array('sub'=>$subject,'message'=>$message);
    
            try {
                Mail::to($user->email)->send(new GlobalMail($data));
            } catch (\Exception $e) {
            // Log the error message
            \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
            // Collect invalid email
                $invalidEmails[] = $user->email;
            }
        }else {
            $invalidEmails[] = $user->email;
        }
        
        // Check if there were any invalid emails
        if (!empty($invalidEmails)) {
            session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
        } else {
            Session()->flash('success','Application Approved');
        }
        return redirect()->back();
    }
    
    public function rejectApp($jid,$uid){
        $app = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $app->status=2;
        $app->save();
        $gig = Gig::find($jid);
        $user = User::find($uid);


        // $client = new \GuzzleHttp\Client();
                                            
        // $response = $client->request('POST', 'https://fcm.googleapis.com/v1/projects/herody-bf512/messages:send', [
        //     'body' => '{message: {token:' .$user->rigistration_token. ',priority: "high",data: {title: "Title Test",body: "This is body text"}}}',
        //     'headers' => [
        //     'content-type' => 'application/json',
        //     ],
        // ]);

        
        // Mails
        if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $subject = 'Application Rejected';
            $message = "<p>Dear {$user->name},</p><p>Sorry , You are not selected for {$gig->campaign_title} .Please Try another gigs.</p>";
            $data = array('sub'=>$subject,'message'=>$message);
    
            try {
                Mail::to($user->email)->send(new GlobalMail($data));
            } catch (\Exception $e) {
            // Log the error message
            \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
            // Collect invalid email
                $invalidEmails[] = $user->email;
            }
        }else {
            $invalidEmails[] = $user->email;
        }
        
        // Check if there were any invalid emails
        if (!empty($invalidEmails)) {
            session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
        } else {
            Session()->flash('success','Application Rejected');
        }
        return redirect()->back();
    }
    
    
    // public function approveAll(Request $request) {
    //     $employer = Employer::find(Auth::guard('employer')->id());
    //     $id = $request->id;
    //     $gig = Gig::find($request->id);
    
    //     if ($gig->user_id == $employer->id) {
    //         // Get all applications with status 0 for the specified gig
    //         $applications = GA::where('cid', $id)->where('status', 0)->get();
            
    //         if ($applications->isEmpty()) {
    //             session()->flash('warning', 'No applications found to approve on this page');
    //             return redirect()->back();
    //         }
            
    //         // Collect invalid emails
    //         $invalidEmails = [];
            
    //         // Update status and send emails
    //         foreach ($applications as $application) {
    //             $application->update(['status' => 1]);
    //             $user = User::find($application->uid); // Assuming you have a User model
                
    //             // Validate email
    //             if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    //                 $subject = 'Application Approved';
    //                 $message = "<p>Dear {$user->name},</p><p>We congratulate you on your selection in {$gig->campaign_title}.</p>";
    //                 $data = array('sub' => $subject, 'message' => $message);
    
    //                 try {
    //                     Mail::to($user->email)->send(new GlobalMail($data));
    //                 } catch (\Exception $e) {
    //                     // Log the error message
    //                     \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
    //                     // Collect invalid email
    //                     $invalidEmails[] = $user->email;
    //                 }
    //             }else {
    //             $invalidEmails[] = $user->email;
    //             }
    //         }
    //         // Check if there were any invalid emails
    //         if (!empty($invalidEmails)) {
    //             session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
    //         } else {
    //             session()->flash('success', 'All pending applications have been approved');
    //         }
            
    //         return redirect()->back();
    //     } else {
    //         session()->flash('warning', 'You cannot approve users for this project');
    //         return redirect()->back();
    //     }
    // }
   public function approveAll(Request $request) {
    $employer = Employer::find(Auth::guard('employer')->id());
    $id = $request->id;
    $gig = Gig::find($id);

    if ($gig->user_id == $employer->id) {
        // Get all applications with status 0 for the specified gig
        $applications = GA::where('cid', $id)->where('status', 0)->get();

        if ($applications->isEmpty()) {
            session()->flash('warning', 'No applications found to approve on this page');
            return redirect()->back();
        }

        // Update the status of all applications
        foreach ($applications as $application) {
            $application->update(['status' => 1]);
        }

        session()->flash('success', 'All pending applications have been approved.');
        return redirect()->back();
    } else {
        session()->flash('warning', 'You cannot approve users for this project');
        return redirect()->back();
    }
}

    public function rejectAll(Request $request) {
        $employer = Employer::find(Auth::guard('employer')->id());
        $id = $request->id;
        $gig = Gig::find($request->id);
    
        if ($gig->user_id == $employer->id) {
            // Get all applications with status 0 for the specified gig
            $applications = GA::where('cid', $id)->where('status', 0)->get();
            
            if ($applications->isEmpty()) {
                session()->flash('warning', 'No applications found to reject');
                return redirect()->back();
            }
            
            // Collect invalid emails
            $invalidEmails = [];
    
            // Update status and send emails
            foreach ($applications as $application) {
                $application->update(['status' => 2]);
                $user = User::find($application->uid); // Assuming you have a User model
                
                // Validate email
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    $subject = 'Application Rejected';
                    $message = "<p>Dear {$user->name},</p><p>Sorry , You are not selected for {$gig->campaign_title} .Please Try another gigs.</p>";
                    $data = array('sub'=>$subject,'message'=>$message);
                    
                    try {
                        Mail::to($user->email)->send(new GlobalMail($data));
                    } catch (\Exception $e) {
                        // Log the error message
                        \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
                        // Collect invalid email
                        $invalidEmails[] = $user->email;
                    }
                }else {
                    $invalidEmails[] = $user->email;
                }
            }
                // Check if there were any invalid emails
            if (!empty($invalidEmails)) {
                session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
            } else {
                session()->flash('success', 'All pending applications have been approved');
            }
            return redirect()->back();
        } else {
            session()->flash('warning', 'You cannot approve users for this project');
            return redirect()->back();
        }
    }

    

    
    public function approveAllForRejected(Request $request){
        $employer = Employer::find(Auth::guard('employer')->id());
        $id = $request->id;
        $gig = Gig::find($request->id);
    
        if ($gig->user_id == $employer->id) {
            
            // Get all applications with status 0 for the specified gig
            $applications = GA::where('cid', $id)->where('status', 2)->get();
            
            if ($applications->isEmpty()) {
                session()->flash('warning', 'No applications found to approve');
                return redirect()->back();
            }
            
            // Collect invalid emails
            $invalidEmails = [];
    
            // Update status and send emails
            foreach ($applications as $application) {
                $application->update(['status' => 1]);
                $user = User::find($application->uid); // Assuming you have a User model
                
                // Validate email
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    $subject = 'Application Approved';
                    $message = "Dear {$user->name},</p><p>We congratulate you on your selection in {$gig->campaign_title}.";
                    $data = array('sub'=>$subject,'message'=>$message);
                    
                    try {
                        Mail::to($user->email)->send(new GlobalMail($data));
                    } catch (\Exception $e) {
                        // Log the error message
                        \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
                        // Collect invalid email
                        $invalidEmails[] = $user->email;
                    }
                }else {
                    $invalidEmails[] = $user->email;
                }
            }
                // Check if there were any invalid emails
            if (!empty($invalidEmails)) {
                session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
            } else {
                session()->flash('success', 'All pending applications have been approved');
            }
            return redirect()->back();
        } else {
            session()->flash('warning', 'You cannot approve users for this project');
            return redirect()->back();
        }
    }
    
    
    
    
    
    
    
    
    // public function rejectAllForApproved(Request $request) {
    //     $employer = Employer::find(Auth::guard('employer')->id());
    //     $id = $request->id;
    //     $gig = Gig::find($request->id);
    
    //     if ($gig->user_id == $employer->id) {
            
    //         // Get all applications with status 0 for the specified gig
    //         $applications = GA::where('cid', $id)->where('status', 1)->get();
            
    //         if ($applications->isEmpty()) {
    //             session()->flash('warning', 'No applications found to reject');
    //             return redirect()->back();
    //         }
    //         // Collect invalid emails
    //         $invalidEmails = [];
    
    //         // Update status and send emails
    //         foreach ($applications as $application) {
    //             $application->update(['status' => 2]);
    //             $user = User::find($application->uid); // Assuming you have a User model
                
    //             // Validate email
    //             if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
    //                 $subject = 'Application Rejected';
    //                 $message = "Dear {$user->name},</p><p>Unfortunately, all available slots for {$gig->campaign_title} are currently filled, and we cannot approve your application at this time.";
    //                 $data = array('sub'=>$subject,'message'=>$message);
                    
    //                 try {
    //                     Mail::to($user->email)->send(new GlobalMail($data));
    //                 } catch (\Exception $e) {
    //                     // Log the error message
    //                     \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
    //                     // Collect invalid email
    //                     $invalidEmails[] = $user->email;
    //                 }
    //             }else {
    //                 $invalidEmails[] = $user->email;
    //             }
    //         }
    //             // Check if there were any invalid emails
    //         if (!empty($invalidEmails)) {
    //             session()->flash('warning', 'Some emails were invalid and skipped: ' . implode(', ', $invalidEmails));
    //         } else {
    //             session()->flash('success', 'All pending applications have been approved');
    //         }
    //         return redirect()->back();
    //     } else {
    //         session()->flash('warning', 'You cannot approve users for this project');
    //         return redirect()->back();
    //     }
    // }
    public function rejectAllForApproved(Request $request)
{
    $employer = Employer::find(Auth::guard('employer')->id());
    $id = $request->id;
    $gig = Gig::find($id);

    if (!$gig) {
        session()->flash('warning', 'Gig not found.');
        return redirect()->back();
    }

    if ($gig->user_id == $employer->id) {

        // Get all applications with status 1 for the specified gig
        $applications = GA::where('cid', $id)->where('status', 1)->get();

        if ($applications->isEmpty()) {
            session()->flash('warning', 'No applications found to reject');
            return redirect()->back();
        }

        // Collect invalid emails
        $invalidEmails = [];

        // Update status and send emails
        foreach ($applications as $application) {
            $application->update(['status' => 2]);

            $user = User::find($application->uid); // Assuming you have a User model

            // Check if the user exists before accessing the email
            if ($user) {
                // Validate email
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    $subject = 'Application Rejected';
                    $message = "Dear {$user->name},<br><br>Unfortunately, all available slots for {$gig->campaign_title} are currently filled, and we cannot approve your application at this time.";
                    $data = ['sub' => $subject, 'message' => $message];

                    try {
                        Mail::to($user->email)->send(new GlobalMail($data));
                    } catch (\Exception $e) {
                        // Log the error message
                        \Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
                        // Collect invalid email
                        $invalidEmails[] = $user->email;
                    }
                } else {
                    // Add to invalid emails if the email is not valid
                    $invalidEmails[] = $user->email;
                }
            } else {
                // If user not found, add to invalid emails list
                $invalidEmails[] = 'User ID ' . $application->uid;
            }
        }

        // Check if there were any invalid emails
        if (!empty($invalidEmails)) {
            session()->flash('warning', 'Some emails were invalid or users not found: ' . implode(', ', $invalidEmails));
        } else {
            session()->flash('success', 'All pending applications have been rejected and notified.');
        }

        return redirect()->back();
    } else {
        session()->flash('warning', 'You cannot reject applications for this project');
        return redirect()->back();
    }
}

    
    
    
    public function viewproof($jid,$uid){
        $ga = GA::where(['cid'=>$jid,'uid'=>$uid])->first();
        $apps = CJ::where(['job_id'=>$jid,'user_id'=>$uid])->get();
        return view('employer.gigs.proofs')->with([
            'campaigns' => $apps,
            'ga' => $ga,
        ]);
    }
    
    public function viewproof_after_reject_accept($jid, $uid) {
        $ga = GA::where(['cid' => $jid, 'uid' => $uid])->first();
        $apps = [];
    
        if ($ga && $ga->status == 4) {
            $apps = CJ::where(['job_id' => $jid, 'user_id' => $uid])->get();
        } 
        elseif($ga && $ga->status == 5) {
            $apps = IG::where(['job_id' => $jid, 'user_id' => $uid])->get();
        }
    
        return view('employer.gigs.proofs_after_reject_accept')->with([
            'campaigns' => $apps,
            'ga' => $ga,
        ]);
    }

    
//   public function acceptproof($jid, $uid)
// {
//     // Ensure that the GA record exists
//     $ga = GA::where(['cid' => $jid, 'uid' => $uid])->first();
//     if (!$ga) {
//         Session()->flash('error', "Job application not found.");
//         return redirect()->back();
//     }

//     if ($ga->status == 4) {
//         Session()->flash('success', "Proof already accepted");
//         return redirect()->back();
//     }

//     // Ensure that the Job exists
//     $job = Gig::find($jid);
//     if (!$job) {
//         Session()->flash('error', "Job not found.");
//         return redirect()->back();
//     }

//     // Ensure that the User exists
//     $user = User::find($uid);
//     if (!$user) {
//         Session()->flash('error', "User not found.");
//         return redirect()->back();
//     }

//     // Update the status of GA record
//     $ga->status = 4;
//     $ga->save();

//     // Update the user's balance and spin_count
//     $user->balance += $job->per_cost;
//     $user->spin_count += 1;
//     $user->save();

//     // Record the transaction for the user
//     $tr = new Transition;
//     $tr->uid = $user->id;
//     $tr->reason = "For completing Gig {$job->campaign_title} in {$job->brand}";
//     $tr->transition = "+{$job->per_cost}";
//     $tr->addm = $job->per_cost;
//     $tr->save();

//     // Handle referral bonus if applicable
//     if ($user->ref_by != NULL) {
//         $userr = User::where(['ref_code' => $user->ref_by])->first();
//         if ($userr) {
//             $c = 0.05 * $job->per_cost; // Calculate referral bonus
//             $userr->balance += $c;
//             $userr->save();

//             $tr = new Transition;
//             $tr->uid = $userr->id;
//             $tr->reason = "Referral Bonus for {$job->campaign_title} in {$job->brand} by {$user->email}";
//             $tr->transition = "+{$c}";
//             $tr->addm = $c;
//             $tr->save();
//         }
//     }

//     // Flash success message and redirect back
//     Session()->flash('success', "Proof Accepted");
//     return redirect()->back();
// }

 
  public function acceptproof($jid, $uid)
{
    $ga = GA::where(['cid' => $jid, 'uid' => $uid])->first();
    if ($ga && $ga->status == 4) {
        Session()->flash('success', "Proof already accepted");
        return redirect()->back();
    }

    $job = Gig::find($jid);
    $ga->status = 4;
    $ga->save();

    $user = User::find($uid);
    $user->balance = $user->balance + $job->per_cost;
    $user->spin_count += 1;
    $user->save();

    // Increment completed internships
    $user->completed_tasks += 1; // Increment completed tasks
    $user->save();

    $tr = new Transition;
    $tr->uid = $user->id;
    $tr->reason = "For completing Gig {$job->campaign_title} in {$job->brand}";
    $tr->transition = "+{$job->per_cost}";
    $tr->addm = $job->per_cost;
    $tr->save();

    // Check if the user has a referrer and if the user has completed 3 or more tasks
    if ($user->ref_by != NULL) {
        $userr = User::where(['ref_code' => $user->ref_by])->first();

        // Apply 50% bonus only if the user has completed more than 3 tasks
        $bonusPercentage = $user->completed_tasks <= 2 ? 0.5 : 0; // 50% after 3 tasks, no bonus otherwise

        // Calculate the bonus amount
        $bonusAmount = $bonusPercentage * $job->per_cost;

        if ($bonusAmount > 0) {
            // Update referrer's balance if bonus is applied
            $userr->balance = $userr->balance + $bonusAmount;
            $userr->save();

            // Save transaction for referral bonus
            $tr = new Transition;
            $tr->uid = $userr->id;
            $tr->reason = "Referral Bonus for {$job->campaign_title} in {$job->brand} by {$user->email}";
            $tr->transition = "+{$bonusAmount}";
            $tr->addm = $bonusAmount;
            $tr->save();
        }
    }

    Session()->flash('success', "Accepted");
    return redirect()->back();
}



    
    public function rejectproof($jid, $uid)
    {
        $ga = GA::where(['cid' => $jid, 'uid' => $uid])->first();
        $job = Gig::find($jid);
        $ga->status = 5;
        $ga->save();
    
        $jobs = CJ::where(['job_id' => $jid, 'user_id' => $uid])->get();
        $path = "assets/user/images/proof_file/";
    
        foreach ($jobs as $job) {
            if ($job->proof_file != null) {
            // Specify the destination directory where you want to copy the file
            $destinationPath = "assets/user/images/reject_file/";

            // Build the source file path
            $sourceFile = $path . $job->proof_file;

            // Build the path for the destination
            $destinationFile = $destinationPath . $job->proof_file;

            // Copy the file to the destination directory
            copy($sourceFile, $destinationFile);

            // Create a new record in the IncompletedGig table
            $rejectedProof = new IG;
            $rejectedProof->job_id = $jid;
            $rejectedProof->user_id = $uid;
            $rejectedProof->proof_file = $job->proof_file;
            // Add other fields as needed
            $rejectedProof->save();
            
            unlink($sourceFile);
        }

        // Delete the record from the CJ table
        $job->delete();
        }
    
        // Mail
        // $subject = 'Proof Rejected';
        // $message = "<p>Dear {$user->name},</p><p>Sorry, Your proof has been carefully reviewed for {$job->campaign_title} and unfortunately, it does not meet our criteria for approval at this time.</p>";
        // $data = array('sub'=>$subject,'message'=>$message);
        // Mail::to($user->email)->send(new GlobalMail($data));
    
        Session()->flash('success', "Rejected");
        return redirect()->back();
    }
    
    
    public function export_excel($id){
        $em = Employer::find(Auth::guard('employer')->id());
        $job = Gig::find($id);
        
        if($job==NULL){
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
        if($job->user_id == $em->id){
            $proofs = CJ::where(['job_id' => $id])->get();
            if($proofs->count()==0){
                Session()->flash('warning','No proof found');
                return redirect()->back();
            }
            else{
                $campaignTitle = $job->campaign_title; 
                $currentDate = now()->format('Y-m-d');
                $fileName = $campaignTitle . ' (' . $currentDate . ')' . ' accepted_proofs.xlsx';
                return Excel::download(new GigProofs($id, $campaignTitle), $fileName);
                // return Excel::download(new GigProofs($id), 'proofs.xlsx');
            }
        }
        else{
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
    }
    
    
    // ########
    public function export_reject_excel($id){
        $em = Employer::find(Auth::guard('employer')->id());
        $job = Gig::find($id);
        
        if($job==NULL){
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
        if($job->user_id == $em->id){
            $proofs = IG::where(['job_id' => $id])->get();
            if($proofs->count()==0){
                Session()->flash('warning','No proof found');
                return redirect()->back();
            }
            else{
                $campaignTitle = $job->campaign_title; 
                $fileName = $campaignTitle . ' rejected_proofs.xlsx';
                return Excel::download(new RejectProofs($id, $campaignTitle), $fileName);
                // return Excel::download(new RejectProofs($id), 'rejectproofs.xlsx');
            }
        }
        else{
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
    }
    
    // ########
    
    function edit($id){
        $emp = Employer::find(Auth::guard('employer')->id());
        $campaignCategory = GigCategory::get();
        $gig = Gig::find($id);
        if($gig->user_id == Auth::guard('employer')->id()){
            return view('employer.gigs.edit')->with([
                'employer' => $emp,
                'campaignCategory' => $campaignCategory,
                'gig' => $gig
            ]);
        }
        else{
            Session::flash('error',"You are not allowed to edit this gig");
            return redirect()->back();
        }
    }
    function editp(Request $request,$id){
        $this->validate($request,[
            'per_cost' => 'required|numeric',
            'description' => 'required',
            'campaign_title' => 'required',
        ]);
        $emp = Employer::find(Auth::guard('employer')->id());
        $gig = Gig::find($id);
        if($gig->user_id == Auth::guard('employer')->id()){
            $gig->campaign_title = $request->campaign_title;
            $gig->description = $request->description;
            $gig->per_cost = $request->per_cost;
            $cat = "";
        foreach($request->cat as $cate){
            $cat = $cate.", ".$cat;
        }
        $gig->cats = $cat;
            $gig->save();
            $i=0;

        foreach($request->tasks as $taske){
            $files[$i]= "<a href=\"".$request->filess[$i]."\" class=\"btn btn-link\">Click here to download the file(s)</a>";
            $taske = $taske."<br/>".$files[$i];
            $task = Task::find($id);
            $task->cid = $gig->id;
            $task->task = $taske;
            $task->save();
            $i++;
        }

            $request->session()->flash('success', "Gig edited successfully");
            return redirect()->back();
        }
        else{
            Session::flash('error',"You are not allowed to edit this gig");
            return redirect()->back();
        }
    }
    public function exportapps($id){
        $em = Employer::find(Auth::guard('employer')->id());
        $job = Gig::find($id);
        
        if($job==NULL){
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
        if($job->user_id == $em->id){
            $proofs = GA::where(['cid' => $id])->get();
            if($proofs->count()==0){
                Session()->flash('warning','No applications found');
                return redirect()->back();
            }
            else{
                return Excel::download(new EmGigsApps($id), 'gigs_apps.xlsx');
            }
        }
        else{
            Session()->flash('warning','You cannot perform this action');
            return redirect()->back();
        }
    }
//     public function approveAllpro(Request $request)
// {
//     // Get the authenticated employer
//     $employerId = Auth::guard('employer')->id();
//     $gigId = $request->id;

//     // Find the gig owned by the employer
//     $gig = Gig::where('id', $gigId)->where('user_id', $employerId)->first();
//     if (!$gig) {
//         session()->flash('warning', 'Gig not found or unauthorized access.');
//         return redirect()->back();
//     }

//     // Get all applications for the gig
//     $applications = GA::where('cid', $gigId)->get();
//     if ($applications->isEmpty()) {
//         session()->flash('warning', 'No applications found to approve.');
//         return redirect()->back();
//     }

//     foreach ($applications as $application) {
//         // Update application status
//         $application->update(['status' => 4]);

//         // Update user details
//         $user = User::find($application->uid);
//         if ($user) {
//             // Manually increment balance, completed tasks, and spin count
//             $user->balance += $gig->per_cost;
//             $user->completed_tasks += 1; // Increment completed tasks by 1
//             $user->spin_count += 1; // Increment spin count by 1
//             $user->save(); // Save user changes

//             // Log transaction
//             Transition::create([
//                 'uid' => $user->id,
//                 'reason' => "For completing Gig {$gig->campaign_title} in {$gig->brand}",
//                 'transition' => "+{$gig->per_cost}",
//                 'addm' => $gig->per_cost,
//             ]);

//             // Handle referral bonus
//             if ($user->ref_by) {
//                 $referrer = User::where('ref_code', $user->ref_by)->first();
//                 if ($referrer && $user->completed_tasks <= 3) {
//                     $bonus = 0.5 * $gig->per_cost;
//                     $referrer->balance += $bonus; // Add referral bonus to referrer balance
//                     $referrer->save(); // Save referrer changes

//                     // Log referral transaction
//                     Transition::create([
//                         'uid' => $referrer->id,
//                         'reason' => "Referral Bonus for {$gig->campaign_title} in {$gig->brand}",
//                         'transition' => "+{$bonus}",
//                         'addm' => $bonus,
//                     ]);
//                 }
//             }
//         }
//     }

//     session()->flash('success', 'All applications approved successfully.');
//     return redirect()->back();
// }
public function approveAllpro(Request $request)
{
    // Get the authenticated employer
    $employerId = Auth::guard('employer')->id();
    $gigId = $request->id;

    // Find the gig owned by the employer
    $gig = Gig::where('id', $gigId)->where('user_id', $employerId)->first();
    if (!$gig) {
        session()->flash('warning', 'Gig not found or unauthorized access.');
        return redirect()->back();
    }

    // Get all applications for the gig
    $applications = GA::where('cid', $gigId)->get(['id', 'uid']);
    if ($applications->isEmpty()) {
        session()->flash('warning', 'No applications found to approve.');
        return redirect()->back();
    }

    // Update all application statuses in one query
    GA::where('cid', $gigId)->update(['status' => 4]);

    // Fetch unique user IDs
    $userIds = $applications->pluck('uid')->unique();

    // Process users for spin count, completed tasks, transactions, and referrals
    $users = User::whereIn('id', $userIds)->get();
    foreach ($users as $user) {
        // Update spin count and completed tasks
        $user->spin_count += 1;
        $user->completed_tasks += 1;
        $user->save();

        // Log transaction for completing the gig
        Transition::create([
            'uid' => $user->id,
            'reason' => "For completing Gig {$gig->campaign_title} in {$gig->brand}",
            'transition' => "+{$gig->per_cost}",
            'addm' => $gig->per_cost,
        ]);

        // Handle referral bonus
        if ($user->ref_by) {
            $referrer = User::where('ref_code', $user->ref_by)->first();
            if ($referrer && $user->completed_tasks <= 3) {
                $bonus = 0.5 * $gig->per_cost;
                $referrer->balance += $bonus; // Add referral bonus to referrer balance
                $referrer->save();

                // Log referral transaction
                Transition::create([
                    'uid' => $referrer->id,
                    'reason' => "Referral Bonus for {$gig->campaign_title} in {$gig->brand}",
                    'transition' => "+{$bonus}",
                    'addm' => $bonus,
                ]);
            }
        }
    }

    session()->flash('success', 'All applications approved successfully.');
    return redirect()->back();
}


}
