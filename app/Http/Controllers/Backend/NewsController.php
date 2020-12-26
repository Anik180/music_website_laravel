<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\News;
use Image;


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
            $data->title_two = $request->title_two;
            $data->short_description = $request->short_description;
            $data->description = $request->description;
            $data->youtube_link = $request->youtube_link;
            $data->meta_titles = $request->meta_titles;
            $data->meta_description = $request->meta_description;
            $data->status =  1;
            $maximum_sort_get = News::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }

            // $data->video_link = $request->video_link;
            // if($request->has('youtube_video_link')){
            //     $video_id = explode("?v=", $request->youtube_video_link);
            //     $data->youtube_link = $video_id[0];
            // }

            if($request->file('video')){
                $video = $request->file('video');
                $video_file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/News', $video, $video_file_name);
            //     $destinationPath    = 'storage/app/public/uploads/news/';
            //   Image::make($image->getRealPath())
            //   // original
            //   ->save($destinationPath.$file_name)
            //   // thumbnail
            //   ->resize(320,325)
            //   ->save($destinationPath.'thumb'.$file_name)
            //   // resize
            //   ->resize(330,200) // set true if you want proportional image resize
            //   ->save($destinationPath.'resize'.$file_name)
            //   ->destroy();
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
            $notification=array(
            'messege'=>'Successfully Save',
            'alert-type'=>'success'
         );
return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification=array(
             'messege'=>'Sorry!',
             'alert-type'=>'error'
             );
     return Redirect()->back()->with($notification);
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
            $data->title_two = $request->title_two;
            $data->url = $request->url;
            $data->short_description = $request->short_description;
            $data->description = $request->description;
            $data->youtube_link = $request->youtube_link;
            $data->meta_titles = $request->meta_titles;
            $data->meta_description = $request->meta_description;
            $data->status =  $request->status;

            if($request->file('video')){
                if($data->video){
                    if (Storage::disk('public')->exists('uploads/News/'.$data->video)) {
                        Storage::disk('public')->delete('uploads/News/'.$data->video);
                    }
                }
                $video = $request->file('video');
                $data->video = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/News', $video, $data->video);
            } 
            $data->save();
            $notification=array(
            'messege'=>'Successfully Save',
            'alert-type'=>'success'
         );
return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification=array(
            'messege'=>'Sorry!',
           'alert-type'=>'error'
             );
return Redirect()->back()->with($notification);
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
             $notification=array(
             'messege'=>'Successfully delete',
             'alert-type'=>'success'
             );
return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification=array(
            'messege'=>'Sorry!',
            'alert-type'=>'error'
             );
return Redirect()->back()->with($notification);
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

        //sort update
        $mainData = News::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = News::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = News::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = News::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            $notification=array(
            'messege'=>' Did Not Updated! Sorry!',
            'alert-type'=>'error'
             );
return Redirect()->back()->with($notification);
        }

        if($between_data_get->count() > 0){
           foreach ($between_data_get as $key=>$value) {
                if($value->id != $mainData->id){
                    $value->sort = $request->sort + ($key+1);
                    $value->save();
                }
            }    
        }
        $mainData->save();
        $notification=array(
        'messege'=>'Successfully Save',
        'alert-type'=>'success'
         );
return Redirect()->back()->with($notification);

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
            $notification=array(
           'messege'=>'Successfully Updated',
           'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
           
$notification=array(
          'messege'=>'Sorry!',
           'alert-type'=>'error'
             );
return Redirect()->back()->with($notification);
        }
    }
}
