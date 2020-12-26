<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\OurTeam;
use Carbon\Carbon;
use Image;


class OurTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Our Team'; 
        $data['menu'] = 'our_team';
        $data['sub_menu'] = 'sub_our_team';
        $data['our_team'] = OurTeam::where('status', 1)
                                            ->orderBy('sort','asc')
                                            ->paginate(30);
        return view('backend.our_team', $data);
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
            $our_team = new OurTeam();
            $our_team->name = $request->name;
            $our_team->designation = $request->designation;
            $our_team->facebook_url = $request->facebook;
            $our_team->instragram_url = $request->instragram;
            $our_team->twitter_url = $request->twitter;
            $our_team->email_url = $request->email;
            $our_team->linkedin_url = $request->linkedin;
            $our_team->status = 1; // 1 = active
            $maximum_sort_get = OurTeam::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $our_team->sort = $maximum_sort_get->sort+1;
            }else{
                $our_team->sort = 1;
            }
            $our_team->created_by = Auth::user()->id;
            $our_team->created_at = Carbon::now();

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                // Storage::disk('public')->putFileAs('uploads/OurTeam', $image, $file_name);
                $destinationPath    = 'storage/app/public/uploads/OurTeam/';
               Image::make($image->getRealPath())
               // original
               ->save($destinationPath.$file_name)
              // thumbnail
               ->resize(225,305)
               ->save($destinationPath.'thumb'.$file_name)
              // resize
              ->resize(270,366) // set true if you want proportional image resize
              ->save($destinationPath.'resize'.$file_name)
               ->destroy();
            } else {
                $file_name = null;

            }
            $our_team->photo = $file_name;
            
            $our_team->save();
            $notification=array(
            'messege'=>'Successfully Save',
            'alert-type'=>'success'
             );
        return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            // Toastr::error($e->getMessage(), 'Sorry');
            // return redirect()->back();
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
            $our_expertise = OurTeam::find($request->ourExpertise_id);
            $our_expertise->name = $request->name;
            $our_expertise->designation = $request->designation;
            $our_expertise->facebook_url = $request->facebook;
            $our_expertise->instragram_url = $request->instragram;
            $our_expertise->twitter_url = $request->twitter;
            $our_expertise->email_url = $request->email;
            $our_expertise->linkedin_url = $request->linkedin;
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
            $our_team = OurTeam::find($id);
            if($our_team->photo){
                if (Storage::disk('public')->exists('uploads/OurTeam/'.$our_team->photo)) {
                    Storage::disk('public')->delete('uploads/OurTeam/'.$our_team->photo);
                }
            }
            $our_team->delete();
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
    public function download_image($image_name){
        return response()->download(public_path('uploads/OurTeam/'.$image_name));
    }
    public function image_update(Request $request){
        try {
            $our_team = OurTeam::find($request->ourExpertise_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($our_team->photo){
                    if (Storage::disk('public')->exists('uploads/OurTeam/'.$our_team->photo)) {
                        Storage::disk('public')->delete('uploads/OurTeam/'.$our_team->photo);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/OurTeam', $image, $file_name);
                $our_team->photo = $file_name;
            }
            
            $our_team->save();
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
     * for update sorting
     */
    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = OurTeam::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = OurTeam::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = OurTeam::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = OurTeam::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{

          $notification=array(
          'messege'=>'Did Not Updated! Sorry!',
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