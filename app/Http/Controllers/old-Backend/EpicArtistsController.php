<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use App\EpickArtists;
use App\TrackList;
use Carbon\Carbon;

class EpicArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Epic Artists';
        $data['menu'] = 'epic_artist';
        $data['sub_menu'] = 'sub_epic_artist';
        $data['epick_artists'] = EpickArtists::orderBy('sort', 'asc')->get();
        return view('backend.epick_artists', $data);
    }

    
    public function store(Request $request)
    {
        try {
            $epick_artists = new EpickArtists();

            $epick_artists->name = $request->name;
            $epick_artists->about = $request->about;
            $epick_artists->description = $request->description;
            $epick_artists->music_speciality = $request->music_speciality;
            $epick_artists->facebook = $request->facebook;
            $epick_artists->instragram = $request->instragram;
            $epick_artists->twitter = $request->twitter;
            $epick_artists->youtube = $request->youtube;
            $epick_artists->email = $request->email;
            $epick_artists->linkedin = $request->linkedin;
            $epick_artists->itunes = $request->itunes;
            $epick_artists->bandcamp = $request->bandcamp;
            $epick_artists->disk_download = $request->disk_download;
            $epick_artists->spotify = $request->spotify;
            $epick_artists->apple_music = $request->apple_music;
            $epick_artists->sound_cloud = $request->sound_cloud;
            $epick_artists->website = $request->website;
            $epick_artists->here_more_url = $request->here_more_url;
            $epick_artists->status =  1;
            $epick_artists->sort =  1;
            $epick_artists->created_by = Auth::user()->id;
            $epick_artists->created_at = Carbon::now();

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
            } else {
                $file_name = null;

            }
            $epick_artists->photo = $file_name;

           
            $epick_artists->save();
            Toastr::success('', 'Successfully EpickArtists Added');
            return redirect('admin/epicArtists');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function image_update(Request $request){
        try {
            $epicArtists = EpickArtists::find($request->epick_artists_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($epicArtists->photo){
                    if (Storage::disk('public')->exists('uploads/epicArtists/'.$epicArtists->photo)) {
                        Storage::disk('public')->delete('uploads/epicArtists/'.$epicArtists->photo);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
                $epicArtists->photo = $file_name;
            }

            $epicArtists->save();
            Toastr::success('','Successfully Image Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function get_epicArtists(Request $request)
    {
        $epick_artists = EpickArtists::find($request->epicArtistsId);
        echo json_encode($epick_artists);
    }

  
    public function update(Request $request)
    {
        try {
            $epick_artists = EpickArtists::find($request->epicArtists_id);

            $epick_artists->name = $request->name;
            $epick_artists->about = $request->about;
            $epick_artists->description = $request->description;
            $epick_artists->music_speciality = $request->music_speciality;
            $epick_artists->facebook = $request->facebook;
            $epick_artists->instragram = $request->instragram;
            $epick_artists->twitter = $request->twitter;
            $epick_artists->youtube = $request->youtube;
            $epick_artists->email = $request->email;
            $epick_artists->linkedin = $request->linkedin;
            $epick_artists->itunes = $request->itunes;
            $epick_artists->bandcamp = $request->bandcamp;
            $epick_artists->disk_download = $request->disk_download;
            $epick_artists->spotify = $request->spotify;
            $epick_artists->apple_music = $request->apple_music;
            $epick_artists->sound_cloud = $request->sound_cloud;
            $epick_artists->website = $request->website;
            $epick_artists->here_more_url = $request->here_more_url;
            $epick_artists->status =  $request->status;
            $epick_artists->updated_at = Carbon::now();

            $epick_artists->save();
            Toastr::success('', 'Successfully EpickArtists Updated');
            return redirect('admin/epicArtists');
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
            $epick_artists = EpickArtists::find($id);
            if($epick_artists->photo){
                if (Storage::disk('public')->exists('uploads/epicArtists/'.$epick_artists->photo)) {
                    Storage::disk('public')->delete('uploads/epicArtists/'.$epick_artists->photo);
                }
            }
            $epick_artists->delete();
            Toastr::success('', 'Successfully EpickArtists Deleted');
            return redirect('admin/epicArtists');
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
        if (EpickArtists::where('id', $request->id)
            ->update(['sort'=> $request->sort])) {
            $sort_data = EpickArtists::where('id',$request->sort)->first();
            if($sort_data){
                $sort_data->sort = $request->id;
                $sort_data->save();
            }
            Toastr::success('Successfully Added!', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('Did Not Updated!', 'Sorry');
            return redirect()->back();
        }
    }

    public function track_list($epic_id)
    {
        $data['title'] = 'Track List';
        $data['menu'] = 'epic_artist';
        $data['epic_id'] = $epic_id;
        $data['track_lists'] = TrackList::orderBy('id', 'desc')->where('epic_artists_id',$epic_id)->get();
        return view('backend.track_list', $data);
    }

    public function track_list_store(Request $request)
    {
        try {
            $track_list = new TrackList();

            $track_list->epic_artists_id = $request->epic_artists_id;
            $track_list->name = $request->name;
            $track_list->status =  1;
            $track_list->created_at = Carbon::now();

            if($request->file('music')){
                $music = $request->file('music');
                $file_name = uniqid().'.'.$music->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/music', $music, $file_name);
            } else {
                $file_name = null;

            }
            $track_list->music = $file_name;

            $track_list->save();
            Toastr::success('', 'Successfully Track List Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function track_list_update(Request $request)
    {
        try {
            $track_list = TrackList::find($request->track_list_id);
            $track_list->name = $request->name;
            $track_list->status =  $request->status;
            $track_list->updated_at = Carbon::now();

            $track_list->save();
            Toastr::success('', 'Successfully Track List Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function track_list_delete($id)
    {
       $track_list = TrackList::find($id);
       try {
            $track_list->delete();
            if($track_list->music){
                if (Storage::disk('public')->exists('uploads/music/'.$track_list->music)) {
                    Storage::disk('public')->delete('uploads/music/'.$track_list->music);
                }
            }
            Toastr::success('', 'Successfully Track List Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

    public function track_list_music_upload(Request $request)
    {
        try {
            $track_list = TrackList::find($request->track_list_id);

            if($request->file('music')){
                $music = $request->file('music');
                if($track_list->music){
                    if (Storage::disk('public')->exists('uploads/music/'.$track_list->music)) {
                        Storage::disk('public')->delete('uploads/music/'.$track_list->music);
                    }
                }
                $file_name = uniqid().'.'.$music->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/music', $music, $file_name);
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