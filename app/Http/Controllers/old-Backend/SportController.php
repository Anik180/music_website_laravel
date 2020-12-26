<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use App\Sports;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Sports'; 
        $data['menu'] = 'home';
        $data['sub_menu'] = 'sports_our_speciality';
        $data['sports'] = Sports::orderBy('sort', 'asc')->get();
        return view('backend.sports', $data);
    }

    public function store(Request $request)
    {
        try {
            $data = new Sports();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->outside_link = $request->outside_link;
            $data->sort = 1;
            $data->status = 1;

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Sports', $image, $file_name);
            } else {
                $file_name = null;
            }
            $data->image = $file_name;
            $data->save();
            Toastr::success('','Successfully Data Added');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
        try {
            $data = Sports::find($request->sports_id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->outside_link = $request->outside_link;
            $data->status = $request->status;           
            $data->save();
            Toastr::success('','Successfully Data Updated');
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
            $data = Sports::find($id);
            if($data->image){
                if (Storage::disk('public')->exists('uploads/Sports/'.$data->image)) {
                    Storage::disk('public')->delete('uploads/Sports/'.$data->image);
                }
            }
            $data->delete();
            Toastr::success('','Successfully Data Deleted');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function image_update(Request $request){
        try {
            $data = Sports::find($request->sports_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->image){
                    if (Storage::disk('public')->exists('uploads/Sports/'.$data->image)) {
                        Storage::disk('public')->delete('uploads/Sports/'.$data->image);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Sports', $image, $file_name);
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

    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);
        if(Sports::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = Sports::where('id',$request->sort)->first();
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
