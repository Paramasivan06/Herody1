<?php

// app/Http/Controllers/VendorPaymentController.php

namespace App\Http\Controllers\Admin;

use App\VendorPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VendorPaymentController extends Controller
{
    // Show the payment form for vendors
    public function showPaymentForm()
    {
        return view('admin.vendors.form');
    }

    // Process the payment when the vendor submits the form
  public function processPayment(Request $request)
{
    // Validate the form input
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:15',
        'upi_id' => 'required|string|max:255',
        'amount' => 'required|numeric',
    ]);

    // Store the vendor payment request in the database
    $vendorPayment = new VendorPayment();
    $vendorPayment->name = $request->name;
    $vendorPayment->email = $request->email;
    $vendorPayment->phone = $request->phone;
    $vendorPayment->upi_id = $request->upi_id;
    $vendorPayment->amount = $request->amount;
    $vendorPayment->status = 'pending';  // Initial status as pending
    $vendorPayment->save();

    // Prepare the payment data for the external API (e.g., BulkPe)
    $referenceId = 'TXN-VENDOR-' . uniqid('', true);  // Generate unique reference id
    $paymentData = [
        'amount' => $vendorPayment->amount,
        'upi' => $vendorPayment->upi_id,
        'payment_mode' => 'UPI',
        'beneficiaryName'  => $vendorPayment->name,
        'reference_id' => $referenceId,  // Add reference_id
        'transcation_note' => 'Payment to Vendor ' . $vendorPayment->name,
    ];

    // Process payment via the external API (e.g., BulkPe)
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.bulkpe.in/client/initiatepayout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($paymentData),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer aWSVQNyt+z3IiJHV+YX9Urfeu3k9ovB8ItygeQojyce1LVb0GjKXMeHVBjQEPctUfmsnfTq/vXasRuN3suskauPRo429ihzDfneb331mAj2ZqjuVYEONkmSLAZLOyIlml1dnlN3cbwPLQ+3++jHk3A==',
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    // Decode response
    $responseData = json_decode($response, true);

    // Check if payment was successful
    if (isset($responseData['status']) && $responseData['status'] === true) {
        // Update payment status in the database
        $vendorPayment->status = 'success';
        $vendorPayment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment and payout processed successfully',
            'reference_id' => $referenceId,  // Include reference_id in the response
            'response' => $responseData,
        ]);
    } else {
        // Rollback if payment failed
        $vendorPayment->status = 'failed';
        $vendorPayment->save();

        return response()->json([
            'status' => 'failure',
            'message' => 'Payment processing failed',
            'reference_id' => $referenceId,  // Include reference_id in the response
            'response' => $responseData,
        ], 400);
    }
}

}
