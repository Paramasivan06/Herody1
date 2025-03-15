<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function sendSimpleEmail()
    {
        $toEmail = 'sivaaudhimoolam@gmail.com'; // Replace with the recipient's email address
        $referenceId = uniqid('email_', true); // Generate a unique reference ID
        $timestamp = Carbon::now()->toDateTimeString(); // Get the current timestamp

        try {
            Mail::raw('Hi, this is a test email from Herody.', function ($message) use ($toEmail) {
                $message->to($toEmail)
                        ->subject('Test Email from Herody')
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            return response()->json([
                'message' => "Email sent successfully to {$toEmail}",
                'reference_id' => $referenceId,
                'timestamp' => $timestamp,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send email.',
                'reference_id' => $referenceId,
                'timestamp' => $timestamp,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
