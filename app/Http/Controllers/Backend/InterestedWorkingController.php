<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use App\InterestWorking;
use App\SiteSetting;
use Image;
class InterestedWorkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Interested In Working'; 
        $data['menu'] = 'giving_back';
        $data['sub_menu'] = 'interested-in-working';
        $data['interested_in_working'] = InterestWorking::all();
        $data['title_subtitle'] = SiteSetting::where('key','interested_in_working')->first();
        return view('backend.interested_in_workings', $data);
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
        try {
            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/interestedWorking', $image, $file_name);
            //   $destinationPath    = 'storage/app/public/uploads/education/';
            //   Image::make($image->getRealPath())
            //   // original
            //   ->save($destinationPath.$file_name)
            //   // thumbnail
            //   ->resize(326,245)
            //   ->save($destinationPath.'thumb'.$file_name)
            //   // resize
            //   ->resize(296,222) // set true if you want proportional image resize
            //   ->save($destinationPath.'resize'.$file_name)
            //   ->destroy();
            } else {
                $file_name = null;
            }

            $data = new InterestWorking();
            $data->image = $file_name;
            $maximum_sort_get = InterestWorking::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }
            $data->status = 1;
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
    

    public function update(Request $request)
    {
        try {
            $data = NewAlbum::find($request->album_id);
            $data->title = $request->title;
            $data->url = $request->url;
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = InterestWorking::find($id);
            if($data->photo){
                if (Storage::disk('public')->exists('uploads/interestedWorking/'.$data->photo)) {
                    Storage::disk('public')->delete('uploads/interestedWorking/'.$data->photo);
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
    /**
     * for update sorting
     */
    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = InterestWorking::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = InterestWorking::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = InterestWorking::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = InterestWorking::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            $notification=array(
           'messege'=>'Did Not Updated!', 'Sorry!',
           'alert-type'=>'error'
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

    public function image_update(Request $request){
        try {
            $data = InterestWorking::find($request->int_id);
            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->image){
                    if (Storage::disk('public')->exists('uploads/interestedWorking/'.$data->image)) {
                        Storage::disk('public')->delete('uploads/interestedWorking/'.$data->image);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/interestedWorking', $image, $file_name);
                $data->image = $file_name;
            }
            
            $data->save();
        $notification=array(
          'messege'=>'Successfully Image Updated',
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

    public function subtitle_update(Request $request)
    {
        $this->validate($request,[
            'title_subtitle' => 'required', 
        ]);
        
        if(SiteSetting::where('key','interested_in_working')->update(['value'=>$request->title_subtitle])){
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

    // $logo = $request->file('logo');
    //         if(isset($logo)){
    //             $site_logo = 'logo'.uniqid().'.'.$logo->getClientOriginalExtension();
    //             if($db_logo->value != 'default_logo.svg'){
    //                 if (Storage::disk('public')->exists('setting/'.$db_logo->value)) {
    //                     Storage::disk('public')->delete('setting/'.$db_logo->value);
    //                 }
    //             }
    //             Storage::disk('public')->putFileAs('setting', $logo, $site_logo);
    //         } else{
    //             $site_logo = $db_logo->value;
    //         }
}
