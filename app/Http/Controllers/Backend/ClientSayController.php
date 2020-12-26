<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\ClientSays;
use Image;
class ClientSayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Client Say'; 
        $data['menu'] = 'why_epic';
        $data['sub_menu'] = 'client_say';
        $data['client_say'] = ClientSays::orderBy('sort','asc')->get();
        return view('backend.client_say', $data);
    }
    
    public function store(Request $request)
    {
        try {
            $data = new ClientSays();
            $data->desc = $request->desc;
            $data->status = 1; 
            $maximum_sort_get = ClientSays::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('uploads/ClientSays', $image, $file_name);
                Image::make($image)->resize(80,90)->save('storage/app/public/uploads/ClientSays/'.$file_name);
            } else {
                $file_name = null;
            }

            $data->image = $file_name;

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
            $data = ClientSays::find($request->clent_says_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->image){
                    if (Storage::disk('public')->exists('uploads/ClientSays/'.$data->image)) {
                        Storage::disk('public')->delete('uploads/ClientSays/'.$data->image);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('uploads/ClientSays', $image, $file_name);
                Image::make($image)->resize(80,90)->save('storage/app/public/uploads/ClientSays/'.$file_name);
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
           ' alert-type'=>'error'
             );
return Redirect()->back()->with($notification);
        }
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
    public function update(Request $request)
    {
        try {
            $data = ClientSays::find($request->client_say_id);
            $data->desc = $request->desc;
            $data->status = $request->status; 
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
            $data = ClientSays::find($id);
            if($data->image){
                if (Storage::disk('public')->exists('uploads/ClientSays/'.$data->image)) {
                    Storage::disk('public')->delete('uploads/ClientSays/'.$data->image);
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
        $mainData = ClientSays::find($request->id);
        if($mainData){
            $last_record = ClientSays::orderBy('id','desc')->first();
            $maximum_sort_get = ClientSays::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
               $mainData->save();
            }elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = ClientSays::whereBetween('sort',[($request->sort+1), $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }else{
                $mainData->sort = $request->sort;
                $mainData->save();
            }
            
        }else{
            $notification=array(
            'messege'=>'Sorry!',
           'alert-type'=>'error'
             );
return Redirect()->back()->with($notification);
        }
        
        foreach ($between_data_get as $key=>$value) {
            $value->sort = $request->sort + ($key+1);
            $value->save();
        }

        $notification=array(
        'messege'=>'Successfully Save',
        'alert-type'=>'success'
         );
return Redirect()->back()->with($notification);
        //sort update END
    }
       
}