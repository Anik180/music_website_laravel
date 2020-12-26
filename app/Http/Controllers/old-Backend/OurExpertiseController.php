<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
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
            $our_expertise->sort = 1;
            $our_expertise->status = 1;
            $our_expertise->created_by = Auth::user()->id;
            $our_expertise->created_at = Carbon::now();

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/OurExpertise', $image, $file_name);
            } else {
                $file_name = null;
            }
            $our_expertise->image = $file_name;

            $our_expertise->save();
            Toastr::success('','Successfully Our Expertise Added');
            return redirect('admin/our-expertise');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('','Successfully ourExpertise Updated');
            return redirect('admin/our-expertise');
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
            $our_expertise = OurExpertise::find($id);
            if($our_expertise->image){
                if (Storage::disk('public')->exists('uploads/OurExpertise/'.$our_expertise->image)) {
                    Storage::disk('public')->delete('uploads/OurExpertise/'.$our_expertise->image);
                }
            }
            $our_expertise->delete();
            Toastr::success('','Successfully ourExpertise Deleted');
            return redirect('admin/our-expertise');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/OurExpertise', $image, $file_name);
                $our_expertise->image = $file_name;
            }

            
           
            $our_expertise->save();
            Toastr::success('','Successfully Image Updated');
            return redirect('admin/our-expertise');
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
        if(OurExpertise::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = OurExpertise::where('id',$request->sort)->first();
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
