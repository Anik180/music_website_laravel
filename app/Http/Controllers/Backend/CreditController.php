<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Credit;
use App\SiteSetting;
use Image;
class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Credit'; 
        $data['menu'] = 'home';
        $data['sub_menu'] = 'credit';
        $data['credits'] = Credit::orderBy('sort','asc')->get();
        $data['title_subtitle'] = SiteSetting::where('key','credit')->first();
        return view('backend.credit', $data);
    }

    public function store(Request $request)
    
    {
        
    // $url = $request->youtube_link;
    // preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    // $youtube_id = $match[0];

        try {
            $data = new Credit();
            $data->title = $request->title;
            $data->youtube_link = $request->youtube_link;
            $data->status = 1;
            $maximum_sort_get = Credit::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }
            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('uploads/Credit', $image, $file_name);

              $destinationPath    = 'storage/app/public/uploads/Credit/';
               Image::make($image->getRealPath())
               // original
               ->save($destinationPath.$file_name)
              // thumbnail
               ->resize(345,173)
               ->save($destinationPath.'thumb'.$file_name)
              // resize
              ->resize(336,168) // set true if you want proportional image resize
              ->save($destinationPath.'resize'.$file_name)
               ->destroy();
            } else {
                $file_name = null;
            }
            if($request->file('video')){
                $video = $request->file('video');
                $video_file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/CreditVideo', $video, $video_file_name);
            } else {
                $video_file_name = null;
            }
            $data->image = $file_name;
            $data->video = $video_file_name;
            $data->save();
            $notification=array(
            'messege'=>'Successfully Save',
            'alert-type'=>'success'
             );
        return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
        $notification=array(
        'messege'=>'Sorry!',
        'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);

        }
    }

    public function image_update(Request $request){
        try {
            $data = Credit::find($request->credit_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->image){
                    if (Storage::disk('public')->exists('uploads/Credit/'.$data->image)) {
                        Storage::disk('public')->delete('uploads/Credit/'.$data->image);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Credit', $image, $file_name);
                $data->image = $file_name;
            }

            $data->save();
          $notification=array(
          'messege'=>'Successfully Updated',
          'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);

        } catch (ModelNotFoundException $e) {
            $notification=array(
           'messege'=>'Sorry!',
           'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }
    }
    

    public function subtitle_upadate(Request $request)
    {
        $this->validate($request,[
            'title_subtitle' => 'required', 
        ]);
        
        if(SiteSetting::where('key','credit')->update(['value'=>$request->title_subtitle])){
            $notification=array(
           'messege'=>'Successfully Updated',
           'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
        }else{
          $notification=array(
          'messege'=>'Sorry!',
          'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $url = $request->youtube_link;
        // preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        // $youtube_id = $match[0];
        
        try {
            $data = Credit::find($request->credit_id);
            $data->title = $request->name;
            $data->youtube_link = $request->youtube_link;
            $data->status = $request->status;
            if($request->file('video')){
                $video = $request->file('video');
                $video_file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/CreditVideo', $video, $video_file_name);
                $data->video = $video_file_name;
            }
            $data->save();
            
          $notification=array(
          'messege'=>'Successfully Updated',
          'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);

        } catch (ModelNotFoundException $e) {
            $notification=array(
          'messege'=>'Sorry!',
           'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Credit::find($id);
            if($data->image){
                if (Storage::disk('public')->exists('uploads/Credit/'.$data->image)) {
                    Storage::disk('public')->delete('uploads/Credit/'.$data->image);
                }
            }
            $data->delete();
            $notification=array(
             'messege'=>'Successfully delete',
             'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification=array(
           'messege'=>'Sorry!',
           'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }
    }
  
    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = Credit::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = Credit::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = Credit::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = Credit::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            $notification=array(
          'messege'=>'Successfully Updated',
           'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
        }

        if($between_data_get->count() > 0){
           foreach ($between_data_get as $key=>$value) {
                if($value->id != $mainData->id){
                    $value->sort = $request->sort + ($key+1);
                    $value->save();
                }
            }    
        }
        $mainData->save();
        $notification=array(
          'messege'=>'Successfully Save',
           'alert-type'=>'success'
             );
        return Redirect()->back()->with($notification);
    }

       
}
