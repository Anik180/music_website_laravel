<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
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
        $data['why_epic'] = WhyEpic::all();
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
            Toastr::success('Successfully Updated!','Success');
            return redirect('admin/why-epic-list');
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
        try {WhyEpic::where('id',$id)->delete();
            Toastr::success('Successfully Deleted!','Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
   
}