<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\WhyEpic;

class WhyEpicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Why Epic'; 
        $data['menu'] = 'why_epic';
        $data['sub_menu'] = 'why_epic_list';
        $data['why_epic'] = WhyEpic::orderBy('sort','asc')->get();
        return view('backend.why_epic.why_epic_list', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Why Epic'; 
        $data['menu'] = 'why_epic';
        $data['sub_menu'] = 'why_epic_create';
        return view('backend.why_epic.why_epic_create', $data);
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
            $data = new WhyEpic();
            $data->epic_type = $request->type;
            $data->our_process_type = $request->our_process_type;
            $data->description = $request->description;
            $maximum_sort_get = WhyEpic::orderBy('sort','desc')->first();
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
        $data['title'] = 'Why Epic Update'; 
        $data['menu'] = 'why_epic';
        $data['sub_menu'] = 'why_epic_list';
        $data['why_epic'] = WhyEpic::find($id);
        return view('backend.why_epic.why_epic_edit', $data);
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
            $data = WhyEpic::find($id);
            $data->epic_type = $request->type;
            $data->our_process_type = $request->our_process_type;
            $data->description = $request->description;
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
        try {WhyEpic::where('id',$id)->delete();
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
           public function why_epic_sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);

        //sort update
        $mainData = WhyEpic::find($request->id);
        $mainData->sort = $request->sort;
        if($mainData){
            $maximum_sort_get = WhyEpic::orderBy('sort','desc')->first();
            if($maximum_sort_get->sort < $request->sort){
               $mainData->sort = $request->sort;
            }
            elseif($maximum_sort_get->sort > $request->sort){
                $between_data_get = WhyEpic::whereBetween('sort',[$request->sort, $maximum_sort_get->sort])->orderBy('sort','asc')->get();
            }
            else{
                $between_data_get = WhyEpic::whereBetween('sort',[$maximum_sort_get->sort, $request->sort])->orderBy('sort','asc')->get();
            }
        }else{
            $notification=array(
          'messege'=>'Successfully Updated',
           'alert-type'=>'success'
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
   
}