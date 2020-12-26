<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Slider;
use Carbon\Carbon;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level == 2){
            return redirect('admin/seo-show?seo_menu=home');
        }
        $data['title'] = 'Slider';
        $data['menu'] = 'home';
        $data['sub_menu'] = 'slider';
        $data['sliders'] = Slider::where('status', 1)->latest()->paginate(10);
        return view('backend.slider', $data);
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
            $slider = new Slider();

            $slider->title_1 = $request->title_1;
            $slider->title_2 = $request->title_2;
            $slider->title_3 = $request->title_3;
            $slider->description = $request->description;
            $slider->video_link = $request->video_link;
            if($request->has('youtube_video_link')){
                $video_id = explode("?v=", $request->youtube_video_link);
                $slider->youtube_video_link = $video_id[1];
            }
            $slider->status = 1;
            $slider->created_by = Auth::user()->id;
            $slider->created_at = Carbon::now();

            if($request->file('video')){
                $video = $request->file('video');
                $file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/slider', $video, $file_name);
            } else {
                $file_name = null;

            }

            $slider->video = $file_name;

            $slider->save();
            Toastr::success('','Successfully Slider Added');
            return redirect('admin/slider');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }

    }

    public function update(Request $request)
    {
        try {
            $slider = Slider::find($request->slider_id);

            $slider->title_1 = $request->title_1;
            $slider->title_2 = $request->title_2;
            $slider->title_3 = $request->title_3;
            $slider->description = $request->description;
            $slider->video_link = $request->video_link;
            if($request->has('youtube_video_link')){
                $video_id = explode("?v=", $request->youtube_video_link);
                $slider->youtube_video_link = $video_id[1];
            }
            $slider->status = $request->status;
            $slider->updated_at = Carbon::now();
            if($request->file('video')){
                $video = $request->file('video');
                // old file remove
                if($slider->video){
                    if (Storage::disk('public')->exists('uploads/slider/'.$slider->photo)) {
                        Storage::disk('public')->delete('uploads/slider/'.$slider->photo);
                    }
                }
                $file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/slider', $video, $file_name);
            }

            $slider->save();
            Toastr::success('','Successfully Slider Updated');
            return redirect('admin/slider');
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
    public function destroy(Slider $slider)
    {
        try {
            if($slider->video){
                if (Storage::disk('public')->exists('uploads/slider/'.$slider->photo)) {
                    Storage::disk('public')->delete('uploads/slider/'.$slider->photo);
                }
            }
            $slider->delete();
            Toastr::success('','Successfully Slider Deleted');
            return redirect('admin/slider');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
}

