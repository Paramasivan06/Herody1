<?php

namespace App\Http\Controllers\API;

use App\OfferwallUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferwallUserController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'pubscale_user_id' => 'required|string',
            'user_id' => 'required|integer',
            'signup_ip' => 'nullable|string',
            'last_open_at' => 'nullable|date',
            'app_id' => 'required|string',
            'completed_at' => 'nullable|date',  // Validates the 'completed_at' as a valid date (nullable)
            'utm_source' => 'nullable|string',
        ]);

        // Store the data in the database
        $offerwallUser = OfferwallUser::create($validated);

        return response()->json(['message' => 'Offerwall user stored successfully', 'data' => $offerwallUser], 201);
    }
}
