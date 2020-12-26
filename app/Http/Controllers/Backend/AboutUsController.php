<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use App\AboutUs;
use Carbon\Carbon;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'AboutUs'; 
        $data['about_us'] = AboutUs::where('status', 1)->latest()->paginate(10);
        return view('backend.about_us', $data);
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
            $about_us = new AboutUs();

            $about_us->title = $request->title;
            $about_us->url = $request->url;
            $about_us->description = $request->description;
            $about_us->status = 1;
            $about_us->created_by = Auth::user()->id;
            $about_us->created_at = Carbon::now();
            
            $about_us->save();
            Toastr::success('','Successfully AboutUs Added');
            return redirect('admin/aboutUs');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $about_us = AboutUs::find($request->aboutUs_id);

            $about_us->title = $request->title;
            $about_us->url = $request->url;
            $about_us->description = $request->description;
            $about_us->status = 1;
            $about_us->updated_at = Carbon::now();
            
            $about_us->save();
            Toastr::success('','Successfully AboutUs Updated');
            return redirect('admin/aboutUs');
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
    public function destroy(AboutUs $aboutUs, $id)
    {

       try {
           $about_us = AboutUs::find($id);
           $about_us->delete();
            Toastr::success('','Successfully AboutUs Deleted');
            return redirect('admin/aboutUs');
       } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
}
