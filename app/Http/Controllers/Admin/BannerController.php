<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|string',
            'detail' => 'nullable',
            'image' => 'required|image',
        ]);
        $banners = new Banner(); 
        //image operation
        if( $request->hasFile('image') ) {
            $path = "assets/user/images/banner/";
            $image_name = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            $image_name = idate("U").$image_name;
            if(\move_uploaded_file($tmp,$path.$image_name)){
                $banners->image = $image_name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }else{
            Session()->flash('warning', 'image not found !');
            return redirect()->back();
        }

        $banners->name = $request->name;
        $banners->detail = $request->detail;
        $banners->image = $image_name;
        

        $banners->save();
        //redirect
        Session()->flash('success', 'successfully Created !');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
        $this->validate($request, [
            'name' => 'required|string',
            'detail' => 'nullable',
        ]);

        $banners = Banner::find($request->id);
        $banners->name = $request->name;
        
        $banners->detail = $request->detail;

        //image update
        if( $request->hasFile('image') ) {

            //delete old image
            $path = 'assets/user/images/banner/';
            $location = $path.$banners->image;
            if (file_exists($location)){
                unlink($location);
            }

            //upload new image
            $image_name = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            $image_name = idate("U").$image_name;
            //image update
            if(\move_uploaded_file($tmp,$path.$image_name)){
                $banners->image = $image_name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }

        $banners->save();
        //redirect
        Session()->flash('success', 'successfully updated !');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $banners = Banner::find($request->id);
        $path = 'assets/user/images/banner/';

        $location = $path.$banners->image;
        if (file_exists($location)){
            unlink($location);
        }

        Banner::find($request->id)->delete();
        //redirect
        Session()->flash('success', 'successfully deleted !');
        return redirect()->back();
    }
    
}
