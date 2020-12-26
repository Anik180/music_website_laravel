<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\BlogRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\News;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'News'; 
        $data['menu'] = 'news';
        $data['sub_menu'] = 'news_list';
        $data['news_list'] = News::orderBy('sort', 'asc')->get();
        return view('backend.news.news_list', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'News Create'; 
        $data['menu'] = 'news';
        $data['sub_menu'] = 'news_create';
        return view('backend.news.create_news', $data);
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
            $data = new News();
            $data->publish_date = $request->date;
            $data->title = $request->title;
            $data->short_description = $request->short_description;
            $data->description = $request->description;
            $data->youtube_link = $request->youtube_link;
            $data->sort = 0;

            $data->video_link = $request->video_link;
            if($request->has('youtube_video_link')){
                $video_id = explode("?v=", $request->youtube_video_link);
                $data->youtube_link = $video_id[0];
            }

            if($request->file('video')){
                $video = $request->file('video');
                $video_file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/News', $video, $video_file_name);
            } else {
                $video_file_name = null;
            }

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/News', $image, $file_name);
            } else {
                $file_name = null;

            }
            $data->video = $video_file_name;
            $data->photo = $file_name;

            $data->save();
            Toastr::success('Successfully Saved!','Success');
            return redirect()->back();
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
        $data['title'] = 'News Update'; 
        $data['menu'] = 'news';
        $data['sub_menu'] = 'news_list';
        $data['news_list'] = News::find($id);
        return view('backend.news.edit_news', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = News::find($id);
            $data->publish_date = $request->date;
            $data->title = $request->title;
            $data->url = $request->url;
            $data->short_description = $request->short_description;
            $data->description = $request->description;
            $data->youtube_link = $request->youtube_link;
            $data->video_link = $request->video_link;
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
            $data = News::find($id);
            if($data->photo){
                if (Storage::disk('public')->exists('uploads/News/'.$data->photo)) {
                    Storage::disk('public')->delete('uploads/News/'.$data->photo);
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
        if(News::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = News::where('id',$request->sort)->first();
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
            $data = News::find($request->news_id);
            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->photo){
                    if (Storage::disk('public')->exists('uploads/News/'.$data->photo)) {
                        Storage::disk('public')->delete('uploads/News/'.$data->photo);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/News', $image, $file_name);
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
}
