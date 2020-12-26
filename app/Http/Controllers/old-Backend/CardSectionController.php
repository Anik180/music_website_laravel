<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use App\CardSection;
use Carbon\Carbon;

class CardSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Card Section'; 
        $data['card_section'] = CardSection::where('status', 1)->latest()->paginate(10);
        return view('backend.card_section', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        try {
            $card_section = new CardSection();

            $card_section->title = $request->title;
            $card_section->description = $request->description;
            $card_section->url = $request->url;
            $card_section->status = 1;
            $card_section->created_by = Auth::user()->id;
            $card_section->created_at = Carbon::now();
            $date = date('m-d-Y_hia');

            if($request->hasFile('image')){
                $photo = $request->file('image');
                $photo_name = Str::slug($request->title, '_').'_'.$date_time = date('m_d_Y_his').'.'.$photo->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/CardSection');
                $photo->move($destinationPath, $photo_name);
                $card_section->photo = $photo_name;
            }

            $card_section->save();
            Toastr::success('','Successfully CardSection Added');
            return redirect('admin/cardSection');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $card_section = CardSection::find($request->card_section_id);

            $card_section->title = $request->title;
            $card_section->description = $request->description;
            $card_section->url = $request->url;
            $card_section->status = $request->status;
            $card_section->updated_at = Carbon::now();
            $date = date('m-d-Y_hia');

            if($request->hasFile('image')){
                $photo = $request->file('image');
                File::delete(public_path('uploads/CardSection/'.$card_section->photo));
                $photo_name = Str::slug($request->title, '_').'_'.$date_time = date('m_d_Y_his').'.'.$photo->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/CardSection');
                $photo->move($destinationPath, $photo_name);
                $card_section->photo = $photo_name;
            }

            $card_section->save();
            Toastr::success('','Successfully CardSection Updated');
            return redirect('admin/cardSection');
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
            $card_section = CardSection::find($id);
            if($card_section->photo){
                File::delete(public_path('uploads/CardSection/'.$card_section->photo));
            }
            $card_section->delete();
            Toastr::success('','Successfully CardSection Deleted');
            return redirect('admin/cardSection');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
}
