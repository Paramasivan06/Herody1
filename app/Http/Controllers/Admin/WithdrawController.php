<?php

namespace App\Http\Controllers\Admin;

use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use App\WithdrawRequest;
use Excel;
use App\Exports\AllWithdrawals;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdraws = Withdraw::all();
        return view('admin.withdraw.index',compact('withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|string',
            'detail' => 'required',
            'image' => 'required|image',
        ]);

        //image operation
        if( $request->hasFile('image') ) {
            try {

                $path = 'assets/user/images/withdraw/';

                $input_image = Image::make($request->image);
                $image = $input_image->resize(160, 80);
                $image_name = $request->file('image')->getClientOriginalName();
                $image_name = Carbon::now()->format('YmdHs').'_'.$image_name;
                $image->save($path.$image_name);

            }catch(\Exception $exp) {
                Session()->flash('warning', 'image upload failed !');
                return redirect()->back();
            }
        }else{
            Session()->flash('warning', 'image not found !');
            return redirect()->back();
        }


        $withdraws = new Withdraw();
        $withdraws->name = $request->name;
        $withdraws->detail = $request->detail;
        $withdraws->image = $image_name;
        

        $withdraws->save();
        //redirect
        Session()->flash('success', 'successfully Created !');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|string',
            'detail' => 'required',
        ]);

        $withdraws = Withdraw::find($request->id);
        $withdraws->name = $request->name;
        
        $withdraws->detail = $request->detail;

        //image update
        if( $request->hasFile('image') ) {

            //delete old image
            $path = 'assets/user/images/withdraw/';
            $location = $path.$withdraws->image;
            if (file_exists($location)){
                unlink($location);
            }

            //upload new image
            $input_image = Image::make($request->image);
            $image = $input_image->resize(160, 80);
            $image_name = $request->file('image')->getClientOriginalName();
            $image_name = Carbon::now()->format('YmdHs').'_'.$image_name;
            $image->save($path.$image_name);

            //image update
            $withdraws->image = $image_name;
        }

        $withdraws->save();
        //redirect
        Session()->flash('success', 'successfully updated !');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $withdraws = Withdraw::find($request->id);
        $path = 'assets/user/images/withdraw/';

        $location = $path.$withdraws->image;
        if (file_exists($location)){
            unlink($location);
        }

        Withdraw::find($request->id)->delete();
        //redirect
        Session()->flash('success', 'successfully deleted !');
        return redirect()->back();
    }
    public function export_excel(){
        $wrs = WithdrawRequest::get();
        if($wrs->count()==0){
            Session()->flash('warning','No withdrawal request found');
            return redirect()->back();
        }
        else{
            return Excel::download(new AllWithdrawals(), 'withdrawals.xlsx');
        }
    }
//     public function processPayout(Request $request, $id)
// {
//     // Fetch the withdrawal details using the given ID
//     $withdrawal = WithdrawRequest::findOrFail($id);  // Assuming 'WithdrawRequest' is the model for the 'withdraw' table

//     // Prepare the data for the payout request
//     $body = [
//         'amount'           => $withdrawal->payable_amount,  // Dynamically fetched payable amount
//         'account_number'   => $withdrawal->account_number,  // Assuming 'account_number' exists in the withdrawal record
//         'payment_mode'     => 'UPI',  // Fixed payment mode
//         'reference_id'     => 'TXN-WD-' . uniqid('', true),  // Generate unique reference ID
//         'transcation_note' => 'Herody Rewards',  // Transaction note
//         'beneficiaryName'  => $withdrawal->user->name,  // Beneficiary name (assuming 'user' relationship exists)
//         'ifsc'             => $withdrawal->ifsc,  // Assuming 'ifsc' exists in the withdrawal record
//         'upi'              => $withdrawal->payment_details,  // UPI ID from withdrawal record
//     ];

   
//     $curl = curl_init();

    
//     curl_setopt_array($curl, array(
//         CURLOPT_URL => 'https://api.bulkpe.in/client/initiatepayout',
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => '',
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 0,
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => 'POST',
//         CURLOPT_POSTFIELDS => json_encode($body),  // Use the dynamically populated $body
//         CURLOPT_HTTPHEADER => [
//             'Content-Type: application/json',
//             'Authorization: Bearer aWSVQNyt+z3IiJHV+YX9Urfeu3k9ovB8ItygeQojyce1LVb0GjKXMeHVBjQEPctUfmsnfTq/vXasRuN3suskauPRo429ihzDfneb331mAj2ZqjuVYEONkmSLAZLOyIlml1dnlN3cbwPLQ+3++jHk3A=='  // Replace with actual API key
//         ],
//     ));

//     // Execute the cURL request and capture the response
//     $response = curl_exec($curl);

//     // Close the cURL session
//     curl_close($curl);

//     // Decode the response from the API
//     $responseData = json_decode($response, true);

//     // Check if the 'status' is true in the response
//     if (isset($responseData['status']) && $responseData['status'] === true) {
//         $withdrawal->status = 1;  
//         $withdrawal->save();  
//         //session()->flash('success', 'Payout processed successfully!');
        
//      }
//     //else {
//     //     // Flash error message to the session if payout fails
//     //     session()->flash('error', 'Failed to process payout. Please try again.');
//     // }


//     // Return the response as JSON
//     return response()->json([
//         'status' => 'success',
//         'message' => 'Payout processed successfully',
//         'response' => $responseData,  // Return the decoded response data
//     ]);
// }
//   return redirect()->route('admin.show.withdraw.request');
public function processPayout(Request $request, $id)
{
    // Fetch the withdrawal details using the given ID
    $withdrawal = WithdrawRequest::findOrFail($id); // Assuming 'WithdrawRequest' is the model for the 'withdraw' table

    // Prepare the data for the payout request
    $body = [
        'amount'           => $withdrawal->payable_amount, // Dynamically fetched payable amount
        'account_number'   => $withdrawal->account_number, // Assuming 'account_number' exists in the withdrawal record
        'payment_mode'     => 'UPI', // Fixed payment mode
        'reference_id'     => 'TXN-WD-' . uniqid('', true), // Generate unique reference ID
         'transcation_note' => 'Herody Rewards ', 
        'beneficiaryName'  => $withdrawal->user->name, // Beneficiary name (assuming 'user' relationship exists)
        'ifsc'             => $withdrawal->ifsc, // Assuming 'ifsc' exists in the withdrawal record
        'upi'              => $withdrawal->payment_details, // UPI ID from withdrawal record
    ];

    // Initialize cURL session
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.bulkpe.in/client/initiatepayout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($body), // Use the dynamically populated $body
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer aWSVQNyt+z3IiJHV+YX9Urfeu3k9ovB8ItygeQojyce1LVb0GjKXMeHVBjQEPctUfmsnfTq/vXasRuN3suskauPRo429ihzDfneb331mAj2ZqjuVYEONkmSLAZLOyIlml1dnlN3cbwPLQ+3++jHk3A==', // Replace with actual API key
        ],
    ]);

    // Execute the cURL request and capture the response
    $response = curl_exec($curl);

    // Close the cURL session
    curl_close($curl);

    // Decode the response from the API
    $responseData = json_decode($response, true);

    // Check if the 'status' is true and message is 'Transaction Initiated!'
    if (isset($responseData['status']) && $responseData['status'] === true && isset($responseData['data']['message']) && $responseData['data']['message'] === 'Transaction Initiated!') {
        // Update withdrawal status to success
        $withdrawal->status = 1;
        $withdrawal->save();

        // Flash success message to the session
        session()->flash('success', 'Payout processed successfully!');
    } 
    elseif (isset($responseData['data']['status']) && $responseData['data']['status'] === 'FAILED') {
        // Set withdrawal status to failed (0)
        $withdrawal->status = 0;
        $withdrawal->save();

        // Flash error message to the session
        session()->flash('error', 'Payout failed after initiation.');
    }
    else {
        // Set withdrawal status to failed
        $withdrawal->status = 0;
        $withdrawal->save();

        // Flash error message to the session
        session()->flash('error', 'Failed to process payout. Please try again.');
    }

    // Redirect to the withdraw request page
    return redirect()->route('admin.show.withdraw.request');
}

}
