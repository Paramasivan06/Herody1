<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserReward;
use App\Transition;
use App\User;
use DB;

class UserRewardController extends Controller
{
    // domain url kya h aapka
    function offer_pb(Request $req){
        $uid=$req->user_id;
        $task_id=$req->token;
        $amount=$req->value;
        
        if(empty($uid) ||  empty($task_id) || empty($amount)){
            return 'Empty Parameter';
        }
        
        $cnt=UserReward::where(['task_id'=>$task_id,'user_id'=>$uid])->count();
        if($cnt>0){
            return 'DUP';
        }
        
        $user=DB::table('users')->where('id',$uid)->select('balance')->first();
        
        if($user){
                
            $res= UserReward::create(['task_id'=>$task_id,'user_id'=>$uid,'points'=>$amount,'reward_date'=>date('Y-m-d')]);
            
            if($res){
                
                $total=$user->balance+$amount;
                DB::table('users')->where('id',$uid)->update(['balance'=>$total]);

                return 'ok';
            }else{
                return 'Somethign went wrong';
            }
        }else{
             return 'User Not Exist!';
        }
        
    }
    
    
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'points' => 'required',
            'task_id'=>'required',
            'reward_date' => 'required',
            
        ]);

        // Store in the database
        $transaction = UserReward::create($validated);

        // Return a JSON response
        if ($transaction) {
            return response()->json([
                'message' => 'Transaction stored successfully',
                'data' => $transaction,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Failed to store transaction',
            ], 500);
        }
    }

// public function calculateAndStorePointsForUser($userId)
// {
//     // Calculate total points for the specific user from the user_rewards table, including task_id
//     $userPoints = DB::table('user_rewards')
//         ->where('user_id', $userId)
//         ->select('user_id', 'task_id', DB::raw('SUM(points) as total_points'))
//         ->groupBy('user_id', 'task_id')  // Group by user_id and task_id to get points for each task
//         ->get();  // Use get() to retrieve all task-wise data

//     if ($userPoints->isNotEmpty()) {
//         foreach ($userPoints as $userPoint) {
//             // Save the data to dummy_user_rewards before clearing the original user_rewards
//             DB::table('dummy_user_rewards')->insert([
//                 'user_id' => $userPoint->user_id,
//                 'task_id' => $userPoint->task_id,
//                 'points' => $userPoint->total_points,
//                 'reward_date' => now(),  // Optional, adjust as necessary
//                 'created_at' => now(),
//                 'updated_at' => now()
//             ]);

//             // Check if the user already exists in user_total_points
//             $existingTotalPoints = DB::table('user_total_points')
//                 ->where('user_id', $userId)
//                 ->value('total_points'); // Get only the total_points value

//             if ($existingTotalPoints) {
//                 // Update the total points by adding the new points for this task
//                 DB::table('user_total_points')
//                     ->where('user_id', $userId)
//                     ->update([
//                         'total_points' => $existingTotalPoints + $userPoint->total_points,
//                         'updated_at' => now()
//                     ]);
//             } else {
//                 // Create a new record for the user in the user_total_points table
//                 DB::table('user_total_points')->insert([
//                     'user_id' => $userId,
//                     'total_points' => $userPoint->total_points,
//                     //'task_id' => $userPoint->task_id, // Store task_id as well
//                     'created_at' => now(),
//                     'updated_at' => now()
//                 ]);
//             }
//         }

//         // Delete the records for the user from the user_rewards table
//         DB::table('user_rewards')->where('user_id', $userId)->delete();

//         // Get the current user's balance
//         $userBalance = DB::table('users')
//             ->where('id', $userId)
//             ->value('balance');

//         // Log for debugging purposes
//         \Log::info("User Balance: " . $userBalance);
        
//         // Calculate the new balance by adding the total points to the current balance
//         $totalPoints = $userPoints->sum('total_points');  // Sum up all task points
//         $newBalance = $userBalance + $totalPoints;

//         // Log the new balance
//         \Log::info("New Balance: " . $newBalance);

//         // Update the user's balance in the users table
//         $updateStatus = DB::table('users')
//             ->where('id', $userId)
//             ->update([
//                 'balance' => $newBalance,  // Store the new balance
//                 'updated_at' => now()
//             ]);

//         // Check if the update was successful
//         if ($updateStatus) {
//             return response()->json([
//                 'message' => 'Total points calculated, stored, and rewards cleared successfully!',
//                 'data' => [
//                     'user_id' => $userId,
//                     'balance' => $newBalance  // Returning the updated balance
//                 ]
//             ]);
//         } else {
//             return response()->json(['message' => 'Failed to update balance'], 500);
//         }
//     }

//     $userTotalPoints = DB::table('user_total_points')
//         ->where('user_id', $userId)
//         ->select('user_id', 'total_points','updated_at')
//         ->first();

//     if ($userTotalPoints) {
//         return response()->json([
//             'message' => 'User total points retrieved successfully!',
//             'data' => $userTotalPoints
//         ]);
//     }

//     // If no points are found for the user in the user_rewards table
//     return response()->json(['message' => 'No points found for this user'], 404);
// }
public function calculateAndStorePointsForUser($userId)
{
    // Calculate total points for the specific user from the user_rewards table, including task_id
    $userPoints = DB::table('user_rewards')
        ->where('user_id', $userId)
        ->select('user_id', 'task_id', DB::raw('SUM(points) as total_points'))
        ->groupBy('user_id', 'task_id')  // Group by user_id and task_id to get points for each task
        ->get();

    if ($userPoints->isNotEmpty()) {
        foreach ($userPoints as $userPoint) {
            // Save the data to dummy_user_rewards before clearing the original user_rewards
            DB::table('dummy_user_rewards')->insert([
                'user_id' => $userPoint->user_id,
                'task_id' => $userPoint->task_id,
                'points' => $userPoint->total_points,
                'reward_date' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Check if the user already exists in user_total_points
            $existingTotalPoints = DB::table('user_total_points')
                ->where('user_id', $userId)
                ->value('total_points');

            if ($existingTotalPoints) {
                DB::table('user_total_points')
                    ->where('user_id', $userId)
                    ->update([
                        'total_points' => $existingTotalPoints + $userPoint->total_points,
                        'updated_at' => now()
                    ]);
            } else {
                DB::table('user_total_points')->insert([
                    'user_id' => $userId,
                    'total_points' => $userPoint->total_points,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // Delete the records for the user from the user_rewards table
        DB::table('user_rewards')->where('user_id', $userId)->delete();

        // Get the current user's balance
        // $user = DB::table('users')->where('id', $userId)->first();
        // if (!$user) {
        //     return response()->json(['message' => 'User not found'], 404);
        // }

        // $userBalance = $user->balance;

        // // Calculate the new balance by adding the total points to the current balance
        // $totalPoints = $userPoints->sum('total_points');  // Sum up all task points
        // $newBalance = $userBalance + $totalPoints;

        // // Update the user's balance in the users table
        // $updateStatus = DB::table('users')
        //     ->where('id', $userId)
        //     ->update([
        //         'balance' => $newBalance,
        //         'updated_at' => now()
        //     ]);

        // Add transaction record for the balance update
        foreach ($userPoints as $userPoint) {
            $tr = new Transition();
            $tr->uid = $userId;
            $tr->reason = "For completing Pubscale";
            $tr->transition = "+{$userPoint->total_points}";
            $tr->addm = $userPoint->total_points;
            $tr->save();
        }

        // Check if the update was successful
        if ($updateStatus) {
            return response()->json([
                'message' => 'Total points calculated, stored, and rewards cleared successfully!',
                'data' => [
                    'user_id' => $userId,
                    'balance' => $newBalance
                ]
            ]);
        } else {
            return response()->json(['message' => 'Failed to update balance'], 500);
        }
    }

    // Retrieve user total points if available
    $userTotalPoints = DB::table('user_total_points')
        ->where('user_id', $userId)
        ->select('user_id', 'total_points', 'updated_at')
        ->first();

    if ($userTotalPoints) {
        return response()->json([
            'message' => 'User total points retrieved successfully!',
            'data' => $userTotalPoints
        ]);
    }

    // If no points are found for the user in the user_rewards table
    return response()->json(['message' => 'No points found for this user'], 404);
}




}
