<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ConfigurationController extends Controller
{
    public function fetchConfiguration(Request $request){
        return response()->json(['response'=>['androidAppVersionCode'=> env("ANDROID_APP_VERSION_CODE", ""), "androidAppForceUpdate"=> env("ANDROID_APP_FORCE_UPDATE", "false"), "IOSAppVersionCode"=> 
        env("IOS_APP_VERSION_CODE", ""),"IOSAppForceUpdate"=> env("IOS_APP_FORCE_UPDATE", "false") ]], 200);
    }
    public function blockUser(Request $request){
        try{
            $this->validate($request,[
                "id"=>"required",
            ]);
            // if (Auth::guard('admin')->check()) {
                $user = User::find($request->id);
                if($user == null){
                    return response()->json(["error"=>"user not found"], 404);
                }
                $user->isBlocked = ($user->isBlocked == 1) ? 0 : 1;
                $user->save();
                $status = $user->isBlocked == 1 ? "Blocked" : "Unblocked";
                // return back()->with('alert','User have been '.$status);
                return response()->json($user, 200);
            // }
            // return view('admin.auth.login');
            return response()->json(["error"=>"failed"], 400);
        }catch(Exception  $error){
            response()->json(["status"=>"", "error"=>"something went wrong"], 400);
        }
    }
    public function getAllUsers(Request $request){
        $users = User::find();
        response()->json($users);
    }
}
