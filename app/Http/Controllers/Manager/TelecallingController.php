<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Telecalling;
use App\TelecallingApp;

class TelecallingController extends Controller
{
    public function index(){
        $telecallings = Telecalling::latest()->paginate(15);
        return view("manager.telecalling.index")->with([
            "telecallings" => $telecallings,
        ]);
    }
    public function create(){
        return view("manager.telecalling.create");
    }
    public function createPost(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "company"=>"required",
            "last_date"=>"required",
            "logo"=>"required|image",
            "script_des"=>"required",
            "script_img"=>"nullable",
            "audio_des"=>"required",
            "audio_file"=>"nullable",
            "obj_des"=>"required",
            "obj_img"=>"nullable",
            "outcome_title"=>"required",
            "outcome_des"=>"required",
            "amount"=>"required",
            "file"=>"required",
        ]);
        $tele = new Telecalling;
        $tele->title = $request->title;
        $tele->category = $request->category;
        $tele->company = $request->company;
        $tele->last_date = $request->last_date;
        $tele->script_des = $request->script_des;
        $tele->audio_des = $request->audio_des;
        $tele->obj_des = $request->obj_des;
        $tele->amount = $request->amount;
        
        // Uploading logo
        if($request->hasFile("logo")){
            $path = "assets/telecalling/logo/";
            $logo = $_FILES["logo"]["name"];
            $tlogo = $_FILES["logo"]["tmp_name"];
            $logo = $request->title."_".$logo;
            if(\move_uploaded_file($tlogo,$path.$logo)){
                $tele->logo = $logo;
            }
            else{
                $request->session()->flash('error', "Project logo cant be uploaded. Please try again.");
                return redirect()->back();
            }
        }
        else{
            $request->session()->flash('error', "Project logo is required");
            return redirect()->back();
        }
        
        // Uploading script image
        if($request->hasFile("script_img")){
            $path = "assets/telecalling/script_img/";
            $script_img = $_FILES["script_img"]["name"];
            $tscript_img = $_FILES["script_img"]["tmp_name"];
            $script_img = $request->title."_".$script_img;
            if(\move_uploaded_file($tscript_img,$path.$script_img)){
                $tele->script_img = $script_img;
            }
            else{
                $request->session()->flash('error', "Project script image cant be uploaded. Please try again.");
                return redirect()->back();
            }
        }
        
        // Uploading audio file
        if($request->hasFile("audio_file")){
            $path = "assets/telecalling/audio_file/";
            $audio_file = $_FILES["audio_file"]["name"];
            $taudio_file = $_FILES["audio_file"]["tmp_name"];
            $audio_file = $request->title."_".$audio_file;
            if(\move_uploaded_file($taudio_file,$path.$audio_file)){
                $tele->audio_file = $audio_file;
            }
            else{
                $request->session()->flash('error', "Project audio file cant be uploaded. Please try again.");
                return redirect()->back();
            }
        }
        
        // Uploading objective image
        if($request->hasFile("obj_img")){
            $path = "assets/telecalling/obj_img/";
            $obj_img = $_FILES["obj_img"]["name"];
            $tobj_img = $_FILES["obj_img"]["tmp_name"];
            $obj_img = $request->title."_".$obj_img;
            if(\move_uploaded_file($tobj_img,$path.$obj_img)){
                $tele->obj_img = $obj_img;
            }
            else{
                $request->session()->flash('error', "Project objective image cant be uploaded. Please try again.");
                return redirect()->back();
            }
        }
        
        // Uploading excel file
        if($request->hasFile("file")){
            $path = "assets/telecalling/file/";
            $file = $_FILES["file"]["name"];
            $tfile = $_FILES["file"]["tmp_name"];
            $file = $request->title."_".$file;
            if(\move_uploaded_file($tfile,$path.$file)){
                $tele->file = $file;
            }
            else{
                $request->session()->flash('error', "Project excel file cant be uploaded. Please try again.");
                return redirect()->back();
            }
        }
        $outcomes = [];
        for($i=0;$i<count($request->outcome_title);$i++){
            $outcomes[$request->outcome_title[$i]] = $request->outcome_des[$i];
        }
        $tele->outcomes = \json_encode($outcomes,true);
        $tele->save();
        $request->session()->flash('success', "Project successfully created");
        return redirect()->back();
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id" => "required"
        ]);
        Telecalling::find($request->id)->delete();
        $apps = TelecallingApp::where("tid",$request->id)->delete();
        $request->session()->flash('success', "Project successfully deleted");
        return redirect()->back();
    }
    public function applications($id){
        $applications = TelecallingApp::where("tid",$id)->latest()->paginate(15);
        return view("manager.telecalling.applications")->with([
            "applications" => $applications,
        ]);
    }
    public function distribute(Request $request){
        $this->validate($request,[
            "id" => "required"
        ]);
        $selecteds = TelecallingApp::where(["tid"=>$request->id,"status"=>1])->get();
        $tele = Telecalling::find($request->id);
        if($selecteds->count()==0){
            $request->session()->flash('warning', "Please select atleast one application to distribute data");
            return redirect()->back();
        }
        else{
            $inputFileName = "assets/telecalling/file/".$tele->file;

            /**  Identify the type of $inputFileName  **/
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            /**  Create a new Reader of the type that has been identified  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($inputFileName);
            $datas = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $keys = $datas[1];
            $datacount = count($datas)-1;
            if($datacount<$selecteds->count()){
                $request->session()->flash('warning', "Selected applications are more than the amount of data in the excel sheet");
                return redirect()->back();
            }
            else{
                $init=2;
                foreach($selecteds as $selected){
                    $selecteddata = [];
                    $j = 0;
                    for($i=$init;$i<((int)($datacount/$selecteds->count()))+$init;$i++){
                        foreach ($keys as $key => $value) {
                            $selecteddata[$j][$value] = $datas[$i][$key];
                        }
                        $j++;
                    }
                    $init = $init + ((int)($datacount/$selecteds->count()));
                    $selected->data = \json_encode($selecteddata,true);
                    $selected->status=3;
                    $selected->save();
                }
                $tele->distributed = 1;
                $tele->save();
                $request->session()->flash('success', "Data has been distributed among all the selected candidates");
                return redirect()->back();
            }
        }
    }
    public function select(Request $request){
        $this->validate($request,[
            "tid" => "required",
            "uid" => "required",
        ]);
        $application = TelecallingApp::where(["tid"=>$request->tid,"uid"=>$request->uid])->first();
        if($application!==NULL){
            $application->status = 1;
            $application->save();
            $request->session()->flash('success', "Application selected");
            return redirect()->back();
        }
        else{
            $request->session()->flash('error', "Not a valid operation");
            return redirect()->back();
        }
    }
    public function reject(Request $request){
        $this->validate($request,[
            "tid" => "required",
            "uid" => "required",
        ]);
        $application = TelecallingApp::where(["tid"=>$request->tid,"uid"=>$request->uid])->first();
        if($application!==NULL){
            $application->status = 2;
            $application->save();
            $request->session()->flash('success', "Application rejected");
            return redirect()->back();
        }
        else{
            $request->session()->flash('error', "Not a valid operation");
            return redirect()->back();
        }
    }
    public function viewData($tid,$uid){
        $application = TelecallingApp::where(["tid"=>$tid,"uid"=>$uid])->first();
        $datas = \json_decode($application->data);
        if(count($datas)==0){
            Session()->flash("error","There is no data");
            return redirect()->back();
        }
        else{
            $keys = array_keys((array)$datas[0]);
            return view("manager.telecalling.view_data")->with([
                "datas" => $datas,
                "keys" => $keys,
            ]);
        }
    }
    public function feedback($id){
        $application = TelecallingApp::find($id);
        if($application->status!==4){
            $request->session()->flash('error', "The user has not submitted the feedback yet");
            return redirect()->back();
        }
        else{
            $feedbacks = json_decode($application->feedback);
            return view("manager.telecalling.feedback")->with([
                "application" => $application,
                "feedbacks" => $feedbacks
            ]);
        }
    }
}
