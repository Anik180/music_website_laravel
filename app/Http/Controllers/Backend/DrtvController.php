<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Drtv;
use App\DrtvMusic;

class DrtvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'DR TV';
        $data['menu'] = 'dr_tv';
        $data['sub_menu'] = 'drtv_artist_list';
        $data['dr_tv'] = Drtv::orderBy('sort', 'asc')->get();
        return view('backend.dr_tv', $data);
    }

    
    public function store(Request $request)
    {
        try {
            $data = new Drtv();
            $data->title = $request->title;
            $data->about = $request->about;
            $data->description = $request->description;
            $data->here_more_url = $request->here_more_url;
            $data->status =  1;
            $maximum_sort_get = Drtv::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }
 
            if($request->file('photo')){
                $photo = $request->file('photo');
                $file_name = uniqid().'.'.$photo->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $photo, $file_name);
            } else {
                $file_name = null;

            }
            if($request->file('photo_one')){
                $photo_one = $request->file('photo_one');
                $file_name_one = uniqid().'.'.$photo_one->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $photo_one, $file_name_one);
            } else {
                $file_name_one = null;

            }
            if($request->file('photo_two')){
                $photo_two = $request->file('photo_two');
                $file_name_two = uniqid().'.'.$photo_two->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $photo_two, $file_name_two);
            } else {
                $file_name_two = null;

            }
            if($request->file('photo_three')){
                $photo_three = $request->file('photo_three');
                $file_name_three = uniqid().'.'.$photo_three->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $photo_three, $file_name_three);
            } else {
                $file_name_three = null;

            }
            if($request->file('photo_four')){
                $photo_four = $request->file('photo_four');
                $file_name_four = uniqid().'.'.$photo_four->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $photo_four, $file_name_four);
            } else {
                $file_name_four = null;

            }
            $data->photo = $file_name;
            $data->photo_one = $file_name_one;
            $data->photo_two = $file_name_two;
            $data->photo_three = $file_name_three;
            $data->photo_four = $file_name_four;
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
            $data = Drtv::find($request->dr_tv_id);
            $data->img_title = $request->title;
            $data->img_alt = $request->alt;
            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->photo){
                    if (Storage::disk('public')->exists('uploads/Drtv/'.$data->photo)) {
                        Storage::disk('public')->delete('uploads/Drtv/'.$data->photo);
                    }
                }
                $file_name = ($request->url) ? str_replace(' ','-',strtolower($request->url)) : uniqid();
                $file_name =  $file_name.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $image, $file_name);
                $data->photo = $file_name;
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
  
    public function update(Request $request)
    {
        try {
            $data = Drtv::find($request->dr_tv_id);
            $data->title = $request->name;
            $data->about = $request->about;
            $data->description = $request->description;
            $data->here_more_url = $request->more_url;
            $data->status =  $request->status;
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
            $data = Drtv::find($id);
            if($data->photo){
                if (Storage::disk('public')->exists('uploads/Drtv/'.$data->photo)) {
                    Storage::disk('public')->delete('uploads/Drtv/'.$data->photo);
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
        $mainData = Drtv::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = Drtv::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = Drtv::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = Drtv::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            Toastr::error('Did Not Updated!', 'Sorry');
            return redirect()->back();
            $notification=array(
           'messege'=>'Did Not Updated!', 'Sorry',
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

    public function music_list($id)
    {
        $data['title'] = 'DR Tv Music List';
        $data['menu'] = 'dr_tv';
        $data['dr_tv_id'] = $id;
        $data['music_list'] = DrtvMusic::orderBy('id', 'desc')->where('drtv_id',$id)->get();
        return view('backend.dr_tv_music_list', $data);
    }

    public function music_store(Request $request)
    {
        try {
            $data = new DrtvMusic();

            $data->drtv_id = $request->dr_tv_id;
            $data->name = $request->name;
            $data->status =  1;
            if($request->file('music')){
                $music = $request->file('music');
                $file_name = uniqid().'.'.$music->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $music, $file_name);
            } else {
                $file_name = null;

            }
            $data->music = $file_name;
            $data->save();
            $notification=array(
           'messege'=>'Successfully Track List Updated',
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

    public function music_update(Request $request)
    {
        try {
            $track_list = DrtvMusic::find($request->track_list_id);
            $track_list->name = $request->name;
            $track_list->status =  $request->status;
            $track_list->save();
             $notification=array(
           'messege'=>'Successfully Track List Updated',
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

    public function music_delete($id)
    {
       $track_list = DrtvMusic::find($id);
       try {
            $track_list->delete();
            if($track_list->music){
                if (Storage::disk('public')->exists('uploads/Drtv/'.$track_list->music)) {
                    Storage::disk('public')->delete('uploads/Drtv/'.$track_list->music);
                }
            }
            $notification=array(
           'messege'=>'Successfully Track List Updated',
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

    public function music_upload(Request $request)
    {
        try {
            $track_list = DrtvMusic::find($request->track_list_id);
            if($request->file('music')){
                $music = $request->file('music');
                if($track_list->music){
                    if (Storage::disk('public')->exists('uploads/Drtv/'.$track_list->music)) {
                        Storage::disk('public')->delete('uploads/Drtv/'.$track_list->music);
                    }
                }
                $file_name = uniqid().'.'.$music->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $music, $file_name);
                $track_list->music = $file_name;
            } 

            $track_list->save();
            $notification=array(
           'messege'=>'Successfully Track Music Updated',
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
}
