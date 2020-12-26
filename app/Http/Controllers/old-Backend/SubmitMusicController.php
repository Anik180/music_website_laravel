<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use App\SubmitMusic;

class SubmitMusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Submit Music'; 
        $data['menu'] = 'submit_music';
        $data['submit_music'] = SubmitMusic::first();
        return view('backend.submit_music', $data);
    }
  
    public function update(Request $request)
    {
        try {
            $data = SubmitMusic::find($request->submit_music_id);
            $data->title_1 = $request->title_1;
            $data->url_1 = $request->url_1;
            $data->title_2 = $request->title_2;
            $data->url_2 = $request->url_2;            
            $data->save();
            Toastr::success('','Successfully Updated');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
    
    
       
}
