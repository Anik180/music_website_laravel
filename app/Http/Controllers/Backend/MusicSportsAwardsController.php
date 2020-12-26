<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\MusicSportsAwardsMenu;
use App\MusicSportsAwards;

class MusicSportsAwardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Music Sports Awards Menu'; 
        $data['menu'] = 'music_sports';
        $data['music_sports_awards_menu'] = MusicSportsAwardsMenu::orderBy('sort', 'asc')->get();
        return view('backend.music_soprts.music_sports_awards_menu', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function awards_list($menu_id)
    {
        $data['title'] = 'Music Sports Awards list';
        $data['menu'] = 'music_sports';
        $data['menu_id'] = $menu_id;
        $data['music_sports_awards'] = MusicSportsAwards::where('music_sports_awards_menus_id',$menu_id)->orderBy('sort', 'asc')->get();
        
        return view('backend.music_soprts.music_sports_awards', $data);
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
            $data = new MusicSportsAwardsMenu();
            $data->title = $request->title;
            $data->url_link = $request->url_link;
            $data->status = 1;
            $maximum_sort_get = MusicSportsAwardsMenu::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function awards_store(Request $request)
    {
        try {
            $data = new MusicSportsAwards();
            $data->music_sports_awards_menus_id = $request->menu_id;
            $data->title = $request->title;
            $data->sub_title = $request->sub_title;
            $data->best_music = $request->best_music;
            $data->description = $request->description;
            $data->video_link    = $request->video_link;
            $maximum_sort_get = MusicSportsAwards::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }
            $data->status = 1;

            if($request->file('image')){
                $video = $request->file('image');
                $file_name = uniqid().'.'.$video->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Awards', $video, $file_name);
            } else {
                $file_name = null;

            }
            $data->video = $file_name;

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
   

    public function update(Request $request)
    {
        try {
            $data = MusicSportsAwardsMenu::find($request->menu_id);
            $data->title = $request->title;
            $data->url_link = $request->url_link;
            $data->status = $request->status;
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

    public function awards_update(Request $request)
    {
      try {
            $data = MusicSportsAwards::find($request->awards_id);
            $data->title = $request->title;
            $data->sub_title = $request->sub_title;
            $data->best_music = $request->best_music;
            $data->description = $request->description;
            $data->video_link    = $request->video_link;
            $data->status = $request->status;
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            MusicSportsAwardsMenu::where('id',$id)->delete();
            MusicSportsAwards::where('music_sports_awards_menus_id',$id)->delete();
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

    public function awards_destroy($id)
    {

        try {
            $data = MusicSportsAwards::find($id);
            if($data->video){
                if (Storage::disk('public')->exists('uploads/epicArtists/'.$data->video)) {
                    Storage::disk('public')->delete('uploads/epicArtists/'.$data->video);
                }
            }
            $data->delete();
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
    /**
     * for update sorting
     */
    public function award_menu_sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = MusicSportsAwardsMenu::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = MusicSportsAwardsMenu::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = MusicSportsAwardsMenu::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = MusicSportsAwardsMenu::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            $notification=array(
          'messege'=>'Sorry!',
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

    public function awards_sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = MusicSportsAwards::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = MusicSportsAwards::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = MusicSportsAwards::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = MusicSportsAwards::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            Toastr::error('Did Not Updated!', 'Sorry');
            return redirect()->back();
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

}
