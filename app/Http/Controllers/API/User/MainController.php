<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class MainController extends Controller
{
    public function login(Request $request){
        $this->validate($request,[
            'phone' => 'required',
           
        ]);
        $user = User::where('phone',$request->phone)->first();
        if($user==NULL){
            return response()->json(['response'=>['code'=>'PHONE NUMBER NOT CORRECT']], 401);
        }
        else{
            
                return response()->json(['response'=>['code'=>'SUCCESS','user' => $user]], 200);
           
        }
    }
    
       
    // userexist function 
    
    public function userexist(Request $request)
    {
        
            // Extract data from request
            $u_id = $request->u_id;
            $email = $request->email;
            $phone = $request->phone;
            
            $data = [];
         
        if((empty($email) && empty($phone)) || empty($u_id)){
            $data['user']    = null;
            $data['status']  = false;
            $data['exist']   = false;
            $data['message'] = 'Uid and Email or Phone Is Required';
            return response()->json($data);
        }
        
       
    
            // Check if user exists by u_id
            $user = User::where('u_id', $u_id)->first();
    
        if ($user) {
            // User found by u_id, return user data
            $data['user'] = $user;
            $data['status'] = true;
            $data['exist'] = true;
            $data['message'] = 'found by u_id';
            return response()->json($data);
        }
    
            // Check if user exists by  email
            $user = User::where('email', $email)->first();
    
        if ($user) {
            // User found by email , update u_id
            $user->u_id = $u_id;
            $user->save();
            $data['user']    = $user;
            $data['status']  = true;
            $data['exist']   = true;
            $data['message'] = 'u_id Update Successfully, found by email';
            return response()->json($data);
        }
        
            // Check if user exists by email 
            $user = User::where('phone', $phone)->first();
    
        if ($user) {
            // User found by phone, update u_id
            $user->u_id = $u_id;
            $user->save();
            $data['user']    = $user;
            $data['status']  = true;
            $data['exist']   = true;
            $data['message'] = 'u_id Update Successfully, found by phone';
            return response()->json($data);
        }else{
            
            $data['user']    = null;
            $data['status']  = true;
            $data['exist']   = false;
            $data['message'] = 'User Not Found';
    
           return response()->json($data);
            
        }
        
    }
    
    
    
    
     public function register(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'ref_by' => 'nullable',
        ]);
        $emailCheck = User::where('email',$request->email)->first();
        if($emailCheck){
            return response()->json(['response'=>['code'=>'EMAIL ALREADY EXISTS']], 401);
        }
        $user = User::where('phone',$request->phone)->first();
        if($user){
            return response()->json(['response'=>['code'=>'PHONE ALREADY EXISTS']], 401);
        }
        
        if($user==NULL){
            if($request->ref_by!=NULL){
                if(\App\User::where('ref_code',$request->ref_by)->exists()){
                    $ref_user_id = User::where('ref_code',$request->ref_by)->first();
                    $ref_by = $request->ref_by;
                }
                else{ 
                    return response()->json(['response'=>['code'=>'REFRAL CODE DOES NOT EXIST']], 401);
                    $ref_by=NULL;
                }
            }
            else{
                $ref_by = NULL;
            }
            while(true){
                $ref_code = $this->randstr(5);
                if(User::where('ref_code',$ref_code)->exists()){

                }
                else{
                    break;
                }
            }
            if($request->password==$request->password_confirmation){
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    
                    'phone' => $request->phone,
                    
                    'ref_by' => $ref_by,
                    'ref_code' => $ref_code,
                ]);
                // $user->sendEmailVerificationNotification();
                return response()->json(['response'=>['code'=>'SUCCESS','user' => $user]], 200);
            }
            else{
                return response()->json(['response'=>['code'=>'PASSWORDS DO NOT MATCH']], 401);
            }
        }
        else{
            return response()->json(['response'=>['code'=>'Something went wrong']], 401);
        }
    }
    
     public function randstr ($len=10, $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789") 
    {
        $letters = str_split($abc);
        $str = "";
        for ($i=0; $i<=$len; $i++) {
            $str .= $letters[rand(0, count($letters)-1)];
        };
        return $str;
    }
    public function loginTC(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $pass = $this->randstr(14);
        $user = User::where('email',$email)->first();
        if($user==NULL){
            while(true){
                $ref_code = $this->randstr(5);
                if(User::where('ref_code',$ref_code)->exists()){

                }
                else{
                    break;
                }
            }
            $user = new User;
            $user->email = $email;
            $user->user_name = $email;
            $user->name = $name;
            $user->phone = $phone;
            $user->password = Hash::make($pass);
            $user->ref_code = $ref_code;
            $user->email_verified_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $user->save();
            return response()->json(['response'=>['code'=>'SUCCESS','user'=>$user]], 200);
        }
        else{
            return response()->json(['response'=>['code'=>'SUCCESS','user'=>$user]], 200);
        }
    }
    public function verifyMobile(Request $request){
        $this->validate($request,[
            'uid' => 'required'
        ]);
        $user = User::find($request->uid);
        $user->app_status=1;
        $user->save();
        return response()->json(['response'=>['code'=>'SUCCESS']], 200);
    }
    public function forgotPassword(Request $request){
        $this->validate($request,[
            'email' => 'required',
        ]);
        $user = User::where('email', request()->input('email'))->first();
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);
        return response()->json(['response'=>['code'=>'SUCCESS']], 200);
    }

    public function getSession(Request $request){
        Auth::loginUsingId($request->id);
        $id = session()->get('name');
        return response()->json(['response'=>['code'=>'SUCCESS','id'=>$id]], 200);
    }
    public function emailVerified(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        $user = User::find($request->id);
        $user->email_verified_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
        return response()->json(['response'=>['code'=>'SUCCESS']], 200);
    }
}
