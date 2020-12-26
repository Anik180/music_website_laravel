<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use App\OurTeam;
use Carbon\Carbon;


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
            $our_team->sort = 1; // 1 = active
            $our_team->created_by = Auth::user()->id;
            $our_team->created_at = Carbon::now();

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/OurTeam', $image, $file_name);
            } else {
                $file_name = null;

            }
            $our_team->photo = $file_name;
            
            $our_team->save();
            Toastr::success('','Successfully Added');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            $our_team = OurTeam::find($id);
            if($our_team->photo){
                if (Storage::disk('public')->exists('uploads/OurTeam/'.$our_team->photo)) {
                    Storage::disk('public')->delete('uploads/OurTeam/'.$our_team->photo);
                }
            }
            $our_team->delete();
            Toastr::success('','Successfully OurTeam Deleted');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('','Successfully Image Updated');
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
        if(OurTeam::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = OurTeam::where('id',$request->sort)->first();
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