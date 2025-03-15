<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Manager;

class HomeController extends Controller
{
    public function loginr(){
        return view('manager.login');
    }
    public function login(Request $request){
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = Manager::where('username',$request->username)->first();
        if($user!=NULL){
            if(Hash::check($request->password, $user->password)){
                Auth::guard('manager')->login($user);
                return redirect()->route('manager.dashboard');
            }
            else{
                Session()->flash('error','Please enter a correct password');
                return redirect()->back();
            }
        }
        else{
            Session()->flash('error','Manager does not exist');
            return redirect()->back();
        }
    }
    public function logout(){
        Auth::guard('manager')->logout();
        return redirect()->route('manager.login');
    }
}
