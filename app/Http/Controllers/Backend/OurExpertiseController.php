<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\OurExpertise;
use Carbon\Carbon;


class OurExpertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Our Expertise'; 
        $data['menu'] = 'home';
        $data['sub_menu'] = 'our_expertise';
        $data['our_expertise'] = OurExpertise::where('status', 1)
                                    ->orderBy('sort', 'asc')
                                    ->paginate(30);
        return view('backend.our_expertise', $data);
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
            $our_expertise = new OurExpertise();
            $our_expertise->title = $request->title;
            $our_expertise->description = $request->description;
            $our_expertise->outside_link = $request->outside_link;
            $maximum_sort_get = OurExpertise::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $our_expertise->sort = $maximum_sort_get->sort+1;
            }else{
                $our_expertise->sort = 1;
            }
            $our_expertise->status = 1;
            $our_expertise->created_by = Auth::user()->id;
            $our_expertise->created_at = Carbon::now();

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('uploads/OurExpertise', $image, $file_name);
                // Image::make($image)->resize(836,695)->save('public/uploads/OurExpertise/'.$file_name);

               $destinationPath    = 'storage/app/public/uploads/OurExpertise/';
               Image::make($image->getRealPath())
               // original
               ->save($destinationPath.$file_name)
              // thumbnail
               ->resize(100,100)
               ->save($destinationPath.'thumb'.$file_name)
              // resize
              ->resize(280,255) // set true if you want proportional image resize
              ->save($destinationPath.'resize'.$file_name)
               ->destroy();

            } else {
                $file_name = null;
            }
            $our_expertise->image = $file_name;

            $our_expertise->save();
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
            $our_expertise = OurExpertise::find($request->ourExpertise_id);
            $our_expertise->title = $request->title;
            $our_expertise->description = $request->description;
            $our_expertise->outside_link = $request->outside_link;
            $our_expertise->status = $request->status;
            $our_expertise->updated_at = Carbon::now();
           
            $our_expertise->save();
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
            $our_expertise = OurExpertise::find($id);
            if($our_expertise->image){
                if (Storage::disk('public')->exists('uploads/OurExpertise/'.$our_expertise->image)) {
                    Storage::disk('public')->delete('uploads/OurExpertise/'.$our_expertise->image);
                }
            }
            $our_expertise->delete();
           
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

    public function image_update(Request $request){
        try {
            $our_expertise = OurExpertise::find($request->ourExpertise_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($our_expertise->image){
                    if (Storage::disk('public')->exists('uploads/OurExpertise/'.$our_expertise->image)) {
                        Storage::disk('public')->delete('uploads/OurExpertise/'.$our_expertise->image);
                    }
                }
                if($request->image_name){
                    $file_name = str_replace(' ','-',strtolower($request->image_name)).'.'.$image->getClientOriginalExtension();
                }else{
                    $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                }
                // Storage::disk('app')->putFileAs('public/uploads/OurExpertise', $image, $file_name);
                Image::make($image)->resize(836,695)->save('storage/app/public/uploads/OurExpertise/'.$file_name);
                $our_expertise->image = $file_name;
                $our_expertise->image_alt = $request->image_alt;
            }
            
            $our_expertise->save();
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

    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = OurExpertise::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = OurExpertise::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = OurExpertise::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = OurExpertise::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            $notification=array(
           'messege'=>'Sorry!',
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

    
}
