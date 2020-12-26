<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;

class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Videos';
        $data['menu'] = 'videos';
        $data['videos'] = Video::orderBy('video_sort','asc')->get();
        return view('backend.video', $data);
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
            $data = new Video();
            $data->video_title = $request->title;
            $data->video_url = $request->url;
            $data->video_sort = 0;
            $data->video_publish = 1;
            $data->save();
            Toastr::success('Successfully Saved', 'Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Warning');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $video)
    {
        try {
            $data = Video::where('video_id', $video)->first();
            $data->video_title = $request->title;
            $data->video_url = $request->url;
            $data->save();
            Toastr::success('Successfully Updated', 'Success');
            return redirect()->back();
        }catch (\ModelNotFoundException $e) {
            Toastr::error("$e->getMessage()", 'Error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($video)
    {
        try {
            Video::where('video_id', $video)->delete();
            Toastr::success('Successfully deleted!', 'Success');
            return redirect()->back();
        } catch (\ModelNotFoundException $e) {
            Toastr::error('Did not deleted!', 'Error');
            return redirect()->back();
        }
    }
}
