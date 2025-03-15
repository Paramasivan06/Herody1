<?php

namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Gig;
use App\PendingGig;
use App\User;
use App\Withdraw;
use App\WithdrawRequest;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Mail;
use App\Transition;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $pendingCampaigns = PendingGig::get();
        $InProOrdersCampaigns = Gig::get();
        $LogCampaigns = Gig::get();
        $withdraws = Withdraw::all();
        $withdrawRequest = WithdrawRequest::where('status',0)->get();
        $withdrawLogs = WithdrawRequest::where('status','!=',0)->get();

        $allUsers = User::all();
        $acUsers = User::where('account_status',1)->get();
        $InAcUsers = User::where('account_status',0)->get();

        return view('admin.pages.dashboard', compact('InAcUsers','acUsers','allUsers','pendingCampaigns','InProOrdersCampaigns', 'withdraws', 'LogCampaigns','withdrawLogs','withdrawRequest'));

    }


    //show withdraw request
//  public function ShowWithdrawRequest()
// {
//     // Fetch all payment details and user_ids where status is 0 or 1
//     $allRequests = WithdrawRequest::whereIn('status', [0, 1])
//         ->select('payment_details', 'user_id', 'status')
//         ->get()
//         ->toArray();

//     // Fetch all withdraw requests with status 0 for display
//     $withdrawRequests = WithdrawRequest::where('status', 0)
//         ->orderBy('updated_at', 'desc')
//         ->get();

//     return view('admin.withdraw.withdraw_request', compact('withdrawRequests', 'allRequests'));
// }
public function ShowWithdrawRequest()
{
    // Fetch all payment details and user_ids where status is 0 or 1
    $allRequests = WithdrawRequest::whereIn('status', [0, 1])
        ->select('payment_details', 'user_id', 'status')
        ->get()
        ->toArray();

    // Fetch all withdraw requests with status 0 for display
    $withdrawRequests = WithdrawRequest::where('status', 0)
        ->orderBy('updated_at', 'desc')
        ->get();

    // Fetch all users' emails and phones with user_id
    $allUsers = \App\User::select('id', 'email', 'phone')->get()->toArray();

    // Create a structure to store duplicate checks
    $duplicateEmails = [];
    $duplicatePhones = [];

    // Check for duplicates in email
    foreach ($allUsers as $user) {
        $email = $user['email'];
        $phone = $user['phone'];

        if (!empty($email)) {
            if (!isset($duplicateEmails[$email])) {
                $duplicateEmails[$email] = [];
            }
            $duplicateEmails[$email][] = $user['id'];
        }

        if (!empty($phone)) {
            if (!isset($duplicatePhones[$phone])) {
                $duplicatePhones[$phone] = [];
            }
            $duplicatePhones[$phone][] = $user['id'];
        }
    }

    // Filter out entries where the email or phone belongs to only one user_id
    $duplicateEmails = array_filter($duplicateEmails, function ($ids) {
        return count($ids) > 1;
    });
    $duplicatePhones = array_filter($duplicatePhones, function ($ids) {
        return count($ids) > 1;
    });

    return view('admin.withdraw.withdraw_request', compact('withdrawRequests', 'allRequests', 'duplicateEmails', 'duplicatePhones'));
}


    public function ShowWithdrawLog()
    {
        $withdrawRequest = WithdrawRequest::where('status','!=',0)->orderBy('updated_at','desc')->paginate(500);
        return view('admin.withdraw.withdraw_log',compact('withdrawRequest'));
    }

    public function WithdrawApproved(Request $request)
    {
        WithdrawRequest::where('id',$request->id)->update(['status' => 1]);

        //send mail to user
        // $withdrawRequest = WithdrawRequest::find($request->id);
        // $to = $withdrawRequest->user->email;
        // $subject = 'Approved withdraw request';
        // $message = 'Your withdraw request is Approved, Thanks for having us';
        // $data = array('sub'=>$subject,'message'=>$message);
        // Mail::to($to)->send(new GlobalMail($data));
        //redirect
        Session()->flash('success', 'Approved!');
        return redirect()->back();
    }

    // public function WithdrawReject(Request $request)
    // {
    //     //return amount of user account
    //       $withdrawRequest = WithdrawRequest::find($request->id);

    //       $return_balance = $withdrawRequest->payable_amount;

    //       $user_balance = $withdrawRequest->user->balance;
    //       $user_balance += $return_balance;

    //       User::where('id', $withdrawRequest->user->id)->update(['balance' => $user_balance]);
          
    //       $tr = new Transition;
    //       $tr->uid = $withdrawRequest->user->id;
    //       $tr->reason = "Withdrawal Rejected";
    //       $tr->transition = "+".$withdrawRequest->payable_amount;
    //       $tr->save();



    //     //change status
    //     WithdrawRequest::where('id',$request->id)->update(['status' => 2]);

    //     //Send mail to user
    //     // $to = $withdrawRequest->user->email;
    //     // $subject = 'Reject withdraw request';
    //     // $message = 'Sorry Your withdraw request is rejected, Please try again later';

    //     // $data = array('sub'=>$subject,'message'=>$message);
    //     // Mail::to($to)->send(new GlobalMail($data));

    //     //redirect
    //     Session()->flash('success', 'Rejected!');
    //     return redirect()->back();
    // }
    public function WithdrawReject(Request $request)
{
    // Find the withdrawal request
    $withdrawRequest = WithdrawRequest::find($request->id);

    if (!$withdrawRequest) {
        return redirect()->back()->with('error', 'Withdrawal request not found.');
    }

    // Check if the user exists
    $user = $withdrawRequest->user;

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Return the amount to the user's account
    $return_balance = $withdrawRequest->payable_amount;
    $user->balance += $return_balance;
    $user->save();

    // Record the transaction
    $tr = new Transition();
    $tr->uid = $user->id;
    $tr->reason = "Withdrawal Rejected";
    $tr->transition = "+" . $return_balance;
    $tr->save();

    // Change status
    $withdrawRequest->update(['status' => 2]);

    // Send rejection email (commented out but you can enable it)
    // Mail::to($user->email)->send(new GlobalMail(['sub' => 'Reject withdraw request', 'message' => 'Sorry, your withdraw request is rejected. Please try again later.']));

    // Redirect with success message
    return redirect()->back()->with('success', 'Withdrawal request rejected successfully!');
}

}
