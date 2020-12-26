<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use App\ContactUs;
use Carbon\Carbon;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Contact Us'; 
        $data['menu'] = 'contact_us';
        $data['contact_us'] = ContactUs::latest()->paginate(10);
        return view('backend.contact_us', $data);
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
        try {
            $contact_us = new ContactUs();

            $contact_us->user_type = $request->user_type;
            $contact_us->first_name = $request->first_name;
            $contact_us->last_name = $request->last_name;
            $contact_us->phone_number = $request->phone;
            $contact_us->email = $request->email;
            $contact_us->company = $request->company;
            $contact_us->company_type = $request->company_type;
            $contact_us->message = $request->message;
            $contact_us->created_at = Carbon::now();

            $contact_us->save();
            Toastr::success('','Thank You For Your Message');
            return redirect('/contact_us');
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
    public function update(Request $request, $id)
    {
        //
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
            $contact_us = ContactUs::find($id);
            $contact_us->delete();
            Toastr::success('','Successfully ContactUs Deleted');
            return redirect('admin/contact-us');
        } catch (ModelNotFoundException $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }
}
