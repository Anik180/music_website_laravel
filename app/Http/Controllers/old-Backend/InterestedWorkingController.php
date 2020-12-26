<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use App\InterestWorking;
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
            } else {
                $file_name = null;
            }

            $data = new InterestWorking();
            $data->image = $file_name;
            $data->sort = 0;
            $data->status = 1;
            $data->save();
            Toastr::success('Successfully Saved!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
    

    public function update(Request $request)
    {
        try {
            $data = NewAlbum::find($request->album_id);
            $data->title = $request->title;
            $data->url = $request->url;
            $data->save();
            Toastr::success('Successfully Updated!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('Successfully Deleted!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
        if(InterestWorking::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = InterestWorking::where('id',$request->sort)->first();
            if($sort_data){
                $sort_data->sort = $request->id;
                $sort_data->save();
            }
            Toastr::success('Successfully Updated!', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('Did Not Updated!', 'Sorry');
            return redirect()->back();
        }
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
            Toastr::success('','Successfully Image Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
