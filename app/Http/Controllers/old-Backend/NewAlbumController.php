<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use App\NewAlbum;

class NewAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'New Album'; 
        $data['menu'] = 'new_album';
        $data['new_album'] = NewAlbum::orderBy('sort', 'asc')->get();
        return view('backend.new_album', $data);
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
                Storage::disk('public')->putFileAs('uploads/newAlbum', $image, $file_name);
            } else {
                $file_name = null;
            }

            $data = new NewAlbum();
            $data->title = $request->title;
            $data->url = $request->url;
            $data->photo = $file_name;
            $data->sort = 0;
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
            $data = NewAlbum::find($id);
            if($data->photo){
                if (Storage::disk('public')->exists('uploads/newAlbum/'.$data->photo)) {
                    Storage::disk('public')->delete('uploads/newAlbum/'.$data->photo);
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
        if(NewAlbum::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = NewAlbum::where('id',$request->sort)->first();
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
            $data = NewAlbum::find($request->ourExpertise_id);
            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->photo){
                    if (Storage::disk('public')->exists('uploads/newAlbum/'.$data->photo)) {
                        Storage::disk('public')->delete('uploads/newAlbum/'.$data->photo);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/newAlbum', $image, $file_name);
                $data->photo = $file_name;
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

