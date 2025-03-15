<?php

namespace App\Http\Controllers\Admin;

use App\GigCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class CampaignCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaign_category = GigCategory::all();
        return view('admin.campaign.campaign_category',compact('campaign_category'));
    }
    public function update(Request $request, $id)
    {
        //validation
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);



        $c_Category = GigCategory::find($request->id);
        $c_Category->name = $request->name;
        $c_Category->status = $request->status;

        //image operation
        if( $request->hasFile('c_photo') ) {
            try {

                //delete old image
                $path = 'assets/admin/img/cate_img/';
                $location = $path.$c_Category->c_photo;
                if (file_exists($location)){
                    unlink($location);
                }


                $input_image = Image::make($request->c_photo);
                $image = $input_image->resize(640, 423);
                $image_name = $request->file('c_photo')->getClientOriginalName();
                $image_name = Carbon::now()->format('YmdHs').'_'.$image_name;
                $image->save($path.$image_name);

            }catch(\Exception $exp) {
                Session()->flash('warning', 'image upload failed !');
                return redirect()->back();
            }
            $c_Category->c_photo = $image_name;
        }

        $c_Category->save();
        //redirect
        Session()->flash('success', 'Updated !');
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
        $c_category = GigCategory::find($request->id);
        $path = 'assets/admin/img/cate_img/';

        if (file_exists($path.$c_category->c_photo)){
            unlink($path.$c_category->c_photo);
        }

        Campaign_category::find($request->id)->delete();

        //redirect
        Session()->flash('success', 'successfully deleted !');
        return redirect()->back();
    }
}
