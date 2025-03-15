<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bform;

class BformController extends Controller
{
    
     public function bform(){
        return view("bform");
    }
    
    public function update(Request $request){
        $this->validate($request,[
            "vname" => "required",
            "vemail" => "required",
            "vmobile" => "required",
            "cname" => "required",
            "area" => "required",
            "msg" => "required",
           
        ]);
        $bform = new Bform;
        $bform->vname = $request->vname;
        $bform->cname = $request->cname;
        $bform->vemail = $request->vemail;
        $bform->vmobile = $request->vmobile;
        $bform->area = $request->area;
        $bform->msg = $request->msg;
        $bform->save();
        $request->session()->flash('success', "Form successfully submitted");
        return redirect()->route("welcome");
    }
    
}