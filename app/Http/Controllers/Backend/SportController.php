<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Sports;
use App\SportArtist;
use App\SportMusic;


class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Sports'; 
        $data['menu'] = 'sports';
        $data['sub_menu'] = 'all_sports';
        $data['sports'] = Sports::orderBy('sort', 'asc')->get();
        return view('backend.sports', $data);
    }

    public function store(Request $request)
    {
        try {
            $data = new Sports();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->outside_link = $request->outside_link;
            $maximum_sort_get = Sports::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }
            $data->status = 1;

            if($request->file('image')){
                $image = $request->file('image');
                $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/Sports', $image, $file_name);
            } else {
                $file_name = null;
            }
            $data->image = $file_name;
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
            $data = Sports::find($request->sports_id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->outside_link = $request->outside_link;
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
            $data = Sports::find($id);
            if($data->image){
                if (Storage::disk('public')->exists('uploads/Sports/'.$data->image)) {
                    Storage::disk('public')->delete('uploads/Sports/'.$data->image);
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

    public function image_update(Request $request){
        try {
            $data = Sports::find($request->sports_id);

            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->image){
                    if (Storage::disk('public')->exists('uploads/Sports/'.$data->image)) {
                        Storage::disk('public')->delete('uploads/Sports/'.$data->image);
                    }
                }
                if($request->image_name){
                    $file_name = str_replace(' ','-',strtolower($request->image_name)).'.'.$image->getClientOriginalExtension();
                }else{
                    $file_name = uniqid().'.'.$image->getClientOriginalExtension();
                }
                Storage::disk('public')->putFileAs('uploads/Sports', $image, $file_name);
                $data->image = $file_name;
                $data->image_alt = $request->image_alt;
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

    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = Sports::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = Sports::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = Sports::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = Sports::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
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
    
    public function sportsartistindex()
    {
        $data['title'] = 'Sports artist';
        $data['menu'] = 'sports';
        $data['sub_menu'] = 'Sports_artist_list';
        $data['Sports'] = SportArtist::orderBy('sort', 'asc')->get();
        return view('backend.SportArtist', $data);
    }
    
      public function sportsartiststore(Request $request)
    {
        try {
            $data = new SportArtist();
            $data->title = $request->name;
            $data->about = $request->about;
            $data->description = $request->description;
            $data->here_more_url = $request->more_url;
            $data->status =  1;
            $maximum_sort_get = SportArtist::orderBy('sort','desc')->first();
            if($maximum_sort_get){
                $data->sort = $maximum_sort_get->sort+1;
            }else{
                $data->sort = 1;
            }
 
            if($request->file('photo')){
                $photo = $request->file('photo');
                $file_name = uniqid().'.'.$photo->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $photo, $file_name);
            } else {
                $file_name = null;

            }
            if($request->file('photo_one')){
                $photo_one = $request->file('photo_one');
                $file_name_one = uniqid().'.'.$photo_one->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $photo_one, $file_name_one);
            } else {
                $file_name_one = null;

            }
            if($request->file('photo_two')){
                $photo_two = $request->file('photo_two');
                $file_name_two = uniqid().'.'.$photo_two->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $photo_two, $file_name_two);
            } else {
                $file_name_two = null;

            }
            if($request->file('photo_three')){
                $photo_three = $request->file('photo_three');
                $file_name_three = uniqid().'.'.$photo_three->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $photo_three, $file_name_three);
            } else {
                $file_name_three = null;

            }
            if($request->file('photo_four')){
                $photo_four = $request->file('photo_four');
                $file_name_four = uniqid().'.'.$photo_four->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $photo_four, $file_name_four);
            } else {
                $file_name_four = null;

            }
            $data->photo = $file_name;
            $data->photo_one = $file_name_one;
            $data->photo_two = $file_name_two;
            $data->photo_three = $file_name_three;
            $data->photo_four = $file_name_four;
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
    
     public function image_main_update(Request $request){
        try {
            $data = SportArtist::find($request->sports_artist_id);
            $data->img_title = $request->title;
            $data->img_alt = $request->alt;
            if($request->file('image')){
                $image = $request->file('image');
                // old file remove
                if($data->photo){
                    if (Storage::disk('public')->exists('uploads/SportArtist/'.$data->photo)) {
                        Storage::disk('public')->delete('uploads/SportArtist/'.$data->photo);
                    }
                }
                $file_name = ($request->url) ? str_replace(' ','-',strtolower($request->url)) : uniqid();
                $file_name =  $file_name.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $image, $file_name);
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
        public function image_one_update(Request $request){
        try {
            $data = SportArtist::find($request->sports_artist_one_id);
            $data->img_one_title = $request->img_one_title;
            $data->img_one_alt = $request->img_one_alt;
            if($request->file('photo_one')){
                $image = $request->file('photo_one');
                // old file remove
                if($data->photo_one){
                    if (Storage::disk('public')->exists('uploads/SportArtist/'.$data->photo_one)) {
                        Storage::disk('public')->delete('uploads/SportArtist/'.$data->photo_one);
                    }
                }
                $file_name = ($request->one_url) ? str_replace(' ','-',strtolower($request->one_url)) : uniqid();
                $file_name =  $file_name.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $image, $file_name);
                $data->photo_one = $file_name;
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
    public function image_two_update(Request $request){
        try {
            $data = SportArtist::find($request->sports_artist_two_id);
            $data->img_two_title = $request->img_two_title;
            $data->img_two_alt = $request->img_two_alt;
            if($request->file('photo_two')){
                $image = $request->file('photo_two');
                // old file remove
                if($data->photo_two){
                    if (Storage::disk('public')->exists('uploads/SportArtist/'.$data->photo_two)) {
                        Storage::disk('public')->delete('uploads/SportArtist/'.$data->photo_two);
                    }
                }
                $file_name = ($request->two_url) ? str_replace(' ','-',strtolower($request->two_url)) : uniqid();
                $file_name =  $file_name.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $image, $file_name);
                $data->photo_two = $file_name;
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
 public function image_three_update(Request $request){
        try {
            $data = SportArtist::find($request->sports_artist_three_id);
            $data->img_three_title = $request->img_three_title;
            $data->img_three_alt = $request->img_three_alt;
            if($request->file('photo_three')){
                $image = $request->file('photo_three');
                // old file remove
                if($data->photo_three){
                    if (Storage::disk('public')->exists('uploads/SportArtist/'.$data->photo_three)) {
                        Storage::disk('public')->delete('uploads/SportArtist/'.$data->photo_three);
                    }
                }
                $file_name = ($request->three_url) ? str_replace(' ','-',strtolower($request->three_url)) : uniqid();
                $file_name =  $file_name.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $image, $file_name);
                $data->photo_three = $file_name;
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
    public function image_four_update(Request $request){
        try {
            $data = SportArtist::find($request->sports_artist_four_id);
            $data->img_four_title = $request->img_four_title;
            $data->img_four_alt = $request->img_four_alt;
            if($request->file('photo_four')){
                $image = $request->file('photo_four');
                // old file remove
                if($data->photo_four){
                    if (Storage::disk('public')->exists('uploads/SportArtist/'.$data->photo_four)) {
                        Storage::disk('public')->delete('uploads/SportArtist/'.$data->photo_four);
                    }
                }
                $file_name = ($request->four_url) ? str_replace(' ','-',strtolower($request->four_url)) : uniqid();
                $file_name =  $file_name.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $image, $file_name);
                $data->photo_four = $file_name;
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
    
     public function sportsartis_sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = SportArtist::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = SportArtist::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = SportArtist::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = SportArtist::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            Toastr::error('Did Not Updated!', 'Sorry');
            return redirect()->back();
            $notification=array(
           'messege'=>'Did Not Updated!', 'Sorry',
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
    
    public function sportsartisdestroy($id)
    {
        try {
            $data = SportArtist::find($id);
            if($data->photo){
                if (Storage::disk('public')->exists('uploads/SportArtist/'.$data->photo)) {
                    Storage::disk('public')->delete('uploads/SportArtist/'.$data->photo);
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
    public function sportsartis_music_list($id)
    {
        $data['title'] = 'Sports Music List';
        $data['menu'] = 'Sports';
        $data['sport_artist_id'] = $id;
        $data['Sport_music_list'] = SportMusic::orderBy('id', 'desc')->where('sport_artist_id',$id)->get();
        return view('backend.sports_music_list', $data);
    }
    
public function sportsartis_music_store(Request $request)
    {
        try {
            $data = new SportMusic();

            $data->sport_artist_id = $request->sport_artist_id;
            $data->name = $request->name;
            $data->status =  1;
            if($request->file('music')){
                $music = $request->file('music');
                $file_name = uniqid().'.'.$music->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $music, $file_name);
            } else {
                $file_name = null;

            }
            $data->music = $file_name;
            $data->save();
            $notification=array(
           'messege'=>'Successfully Track List Updated',
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
 public function sportsartis_music_update(Request $request)
    {
        try {
            $track_list = SportMusic::find($request->track_list_id);
            $track_list->name = $request->name;
            $track_list->status =  $request->status;
            $track_list->save();
             $notification=array(
           'messege'=>'Successfully Track List Updated',
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
        public function sportsartis_music_delete($id)
    {
       $track_list = SportMusic::find($id);
       try {
            $track_list->delete();
            if($track_list->music){
                if (Storage::disk('public')->exists('uploads/SportArtist/'.$track_list->music)) {
                    Storage::disk('public')->delete('uploads/SportArtist/'.$track_list->music);
                }
            }
            $notification=array(
           'messege'=>'Successfully Track List Updated',
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
public function sportsartis_music_upload(Request $request)
    {
        try {
            $track_list = SportMusic::find($request->track_list_id);
            if($request->file('music')){
                $music = $request->file('music');
                if($track_list->music){
                    if (Storage::disk('public')->exists('uploads/SportArtist/'.$track_list->music)) {
                        Storage::disk('public')->delete('uploads/SportArtist/'.$track_list->music);
                    }
                }
                $file_name = uniqid().'.'.$music->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('uploads/SportArtist', $music, $file_name);
                $track_list->music = $file_name;
            } 

            $track_list->save();
            $notification=array(
           'messege'=>'Successfully Track Music Updated',
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
