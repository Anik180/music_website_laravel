<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use App\ClientSays;

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
            $data->sort = 0;

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/ClientSays', $image, $file_name);
            } else {
                $file_name = null;
            }

            $data->image = $file_name;

            $data->save();
            Toastr::success('','Successfully Added');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
                Storage::disk('public')->putFileAs('uploads/ClientSays', $image, $file_name);
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
            Toastr::success('','Successfully Updated');
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
            $data = ClientSays::find($id);
            if($data->image){
                if (Storage::disk('public')->exists('uploads/ClientSays/'.$data->image)) {
                    Storage::disk('public')->delete('uploads/ClientSays/'.$data->image);
                }
            }
            $data->delete();
            Toastr::success('','Successfully Deleted');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
  
    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);
        if(ClientSays::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = ClientSays::where('id',$request->sort)->first();
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
       
}