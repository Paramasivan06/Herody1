<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class EmployerController extends Controller
{
    public function index(){
        $employers = Employer::paginate(50);
        return view('admin.employers.index')->with([
            'employers' => $employers,
        ]);
    }
    public function login(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        $emp = Employer::find($request->id);
        if($emp==NULL){
            $request->session()->flash('error', "The employer does not exist");
            return redirect()->back();
        }
        else{
            if(Auth::guard('employer')->check()){
                Auth::guard('employer')->logout();
            }
            Auth::guard('employer')->login($emp);
            return redirect()->route('employer.dashboard');
        }
    }
    public function create(){
        
        return view("admin.employers.create")->with([
           
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "name"=>"required",
            "email"=>"required",
            "password"=>"required",
            "description"=>"required",
            "phone"=>"required",
            "category"=>"nullable",
            "website"=>"required",
            "cname"=>"required",
            "email_verified"=>"nullable",
            "profile_photo"=>"nullable",
            
        ]);
        $employer = new Employer;
        $employer->name = $request->name;
        $employer->description = $request->description;
        $employer->cname = $request->cname;
        // $employer->password = $request->password;
        $employer->phone = $request->phone;
        $employer->email = $request->email;
        $employer->website = $request->website;
        $employer->password = $request->password;
        $employer->category = $request->category;
        $employer->email_verified = $request->email_verified;
        $employer->password = Hash::make($request->password);
        if($request->hasFile("profile_photo")){
            $tpath = "assets/employer/profile_images/";
            $name = $_FILES["profile_photo"]["name"];
            $tmp = $_FILES["profile_photo"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $employer->profile_photo = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }
        
        
        $employer->save();

        // Mail
        $request->session()->flash('success', "Employer created.");
        return redirect()->back();
    }
    public function delete(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        Employer::find($request->id)->delete();
        $request->session()->flash('success', 'Deleted Successfully');
        return redirect()->back();
    }
}
