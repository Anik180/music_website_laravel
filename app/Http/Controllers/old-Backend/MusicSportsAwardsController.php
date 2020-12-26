<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
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
            $data->sort = 0;
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
    public function awards_store(Request $request)
    {
        try {
            $data = new MusicSportsAwards();
            $data->music_sports_awards_menus_id = $request->menu_id;
            $data->title = $request->title;
            $data->sub_title = $request->sub_title;
            $data->description = $request->description;
            $data->video_link    = $request->video_link;
            $data->sort = 0;
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
            Toastr::success('Successfully Saved!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
            Toastr::success('Successfully Updated!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function awards_update(Request $request)
    {
      try {
            $data = MusicSportsAwards::find($request->awards_id);
            $data->title = $request->title;
            $data->sub_title = $request->sub_title;
            $data->description = $request->description;
            $data->video_link    = $request->video_link;
            $data->status = $request->status;
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
            MusicSportsAwardsMenu::where('id',$id)->delete();
            MusicSportsAwards::where('music_sports_awards_menus_id',$id)->delete();
            Toastr::success('Successfully Deleted!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
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
    public function award_menu_sort_update(Request $request){

        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);
        if(MusicSportsAwardsMenu::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = MusicSportsAwardsMenu::where('id',$request->sort)->first();
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

    public function awards_sort_update(Request $request)
    {
      $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);
        if(MusicSportsAwards::where('id', $request->id)
            ->update(['sort'=> $request->sort])){
            $sort_data = MusicSportsAwards::where('id',$request->sort)->first();
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
