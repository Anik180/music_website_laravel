<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
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
        $data['dr_tv'] = Drtv::orderBy('sort', 'asc')->get();
        return view('backend.dr_tv', $data);
    }

    
    public function store(Request $request)
    {
        try {
            $data = new Drtv();
            $data->title = $request->name;
            $data->about = $request->about;
            $data->description = $request->description;
            $data->here_more_url = $request->more_url;
            $data->status =  1;
            $data->sort =  1;
 
            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Drtv', $image, $file_name);
            } else {
                $file_name = null;

            }
            $data->photo = $file_name;
            $data->save();
            Toastr::success('', 'Successfully Data Added');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('','Successfully Image Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('', 'Successfully Data Updated');
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
            $data = Drtv::find($id);
            if($data->photo){
                if (Storage::disk('public')->exists('uploads/Drtv/'.$data->photo)) {
                    Storage::disk('public')->delete('uploads/Drtv/'.$data->photo);
                }
            }
            $data->delete();
            Toastr::success('', 'Successfully Data Deleted');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * for update sorting
     */
    public function sort_update(Request $request)
    {
        $this->validate($request, [
            'sort' => 'required',
            'id' => 'required',
        ]);
        if (Drtv::where('id', $request->id)
            ->update(['sort'=> $request->sort])) {
            $sort_data = Drtv::where('id',$request->sort)->first();
            if($sort_data){
                $sort_data->sort = $request->id;
                $sort_data->save();
            }
            Toastr::success('Successfully Update!', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('Did Not Updated!', 'Sorry');
            return redirect()->back();
        }
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
            Toastr::success('', 'Successfully Track List Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function music_update(Request $request)
    {
        try {
            $track_list = DrtvMusic::find($request->track_list_id);
            $track_list->name = $request->name;
            $track_list->status =  $request->status;
            $track_list->save();
            Toastr::success('', 'Successfully Track List Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('', 'Successfully Track List Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('','Successfully Music Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
}
