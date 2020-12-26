<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            $maximum_sort_get = EpickArtists::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $epick_artists->sort = $maximum_sort_get->sort+1;
            }else{
                $epick_artists->sort = 1;
            }
            $epick_artists->created_by = Auth::user()->id;
            $epick_artists->created_at = Carbon::now();

            // if($request->file('image')){
            //     $image = $request->file('image');
            //     $file_name = uniqid().'.'.$image->getClientOriginalExtension();
            //     Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
            // } else {
            //     $file_name = null;

            // }
            
             if($request->file('image')){
                $photo = $request->file('image');
                $file_name = uniqid().'.'.$photo->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $photo, $file_name);
            } else {
                $file_name = null;

            }
            if($request->file('photo_one')){
                $photo_one = $request->file('photo_one');
                $file_name_one = uniqid().'.'.$photo_one->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $photo_one, $file_name_one);
            } else {
                $file_name_one = null;

            }
            if($request->file('photo_two')){
                $photo_two = $request->file('photo_two');
                $file_name_two = uniqid().'.'.$photo_two->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $photo_two, $file_name_two);
            } else {
                $file_name_two = null;

            }
            if($request->file('photo_three')){
                $photo_three = $request->file('photo_three');
                $file_name_three = uniqid().'.'.$photo_three->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $photo_three, $file_name_three);
            } else {
                $file_name_three = null;

            }
            if($request->file('photo_four')){
                $photo_four = $request->file('photo_four');
                $file_name_four = uniqid().'.'.$photo_four->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $photo_four, $file_name_four);
            } else {
                $file_name_four = null;

            }
            $epick_artists->photo = $file_name;
            $epick_artists->photo_one = $file_name_one;
            $epick_artists->photo_two = $file_name_two;
            $epick_artists->photo_three = $file_name_three;
            $epick_artists->photo_four = $file_name_four;
           
            $epick_artists->save();
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
     public function image_one_update(Request $request){
        try {
            $oneepicArtists = EpickArtists::find($request->one_epick_artists_id);

            if($request->file('photo_one')){
                $image = $request->file('photo_one');
                // old file remove
                if($oneepicArtists->photo_one){
                    if (Storage::disk('public')->exists('uploads/epicArtists/'.$oneepicArtists->photo_one)) {
                        Storage::disk('public')->delete('uploads/epicArtists/'.$oneepicArtists->photo_one);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
                $oneepicArtists->photo_one = $file_name;
            }

            $oneepicArtists->save();
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
        public function image_two_update(Request $request){
        try {
            $twoepicArtists = EpickArtists::find($request->two_epick_artists_id);

            if($request->file('photo_two')){
                $image = $request->file('photo_two');
                // old file remove
                if($twoepicArtists->photo_two){
                    if (Storage::disk('public')->exists('uploads/epicArtists/'.$twoepicArtists->photo_two)) {
                        Storage::disk('public')->delete('uploads/epicArtists/'.$twoepicArtists->photo_two);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
                $twoepicArtists->photo_two = $file_name;
            }

            $twoepicArtists->save();
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
           public function image_three_update(Request $request){
        try {
            $threeepicArtists = EpickArtists::find($request->three_epick_artists_id);

            if($request->file('photo_three')){
                $image = $request->file('photo_three');
                // old file remove
                if($threeepicArtists->photo_two){
                    if (Storage::disk('public')->exists('uploads/epicArtists/'.$threeepicArtists->photo_three)) {
                        Storage::disk('public')->delete('uploads/epicArtists/'.$threeepicArtists->photo_three);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
                $threeepicArtists->photo_three = $file_name;
            }

            $threeepicArtists->save();
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

    public function image_four_update(Request $request){
        try {
            $fourepicArtists = EpickArtists::find($request->four_epick_artists_id);

            if($request->file('photo_four')){
                $image = $request->file('photo_four');
                // old file remove
                if($fourepicArtists->photo_two){
                    if (Storage::disk('public')->exists('uploads/epicArtists/'.$fourepicArtists->photo_four)) {
                        Storage::disk('public')->delete('uploads/epicArtists/'.$fourepicArtists->photo_four);
                    }
                }
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/epicArtists', $image, $file_name);
                $fourepicArtists->photo_four = $file_name;
            }

            $fourepicArtists->save();
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
            $epick_artists = EpickArtists::find($id);
            if($epick_artists->photo){
                if (Storage::disk('public')->exists('uploads/epicArtists/'.$epick_artists->photo)) {
                    Storage::disk('public')->delete('uploads/epicArtists/'.$epick_artists->photo);
                }
            }
            $epick_artists->delete();
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
        $mainData = EpickArtists::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = EpickArtists::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = EpickArtists::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = EpickArtists::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
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
            $track_list->more_url = $request->more_url;
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
            $notification=array(
            'messege'=>'Successfully Updated',
            'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            $notification=array(
            'messege'=>'Successfully Save',
            'alert-type'=>'success'
             );
        return Redirect()->back()->with($notification);
        }
    }

    public function track_list_update(Request $request)
    {
        try {
            $track_list = TrackList::find($request->track_list_id);
            $track_list->name = $request->name;
            $track_list->more_url = $request->more_url;
            $track_list->status =  $request->status;
            $track_list->updated_at = Carbon::now();

            $track_list->save();
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