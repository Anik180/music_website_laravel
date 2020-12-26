<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Brian2694\Toastr\Facades\Toastr;
use App\ContactUs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
            $mail_data['data']  = $request->all();
            //User Mail Send
            $to_name = $request->first_name.' '.$request->last_name;
            $to_email = $request->email;
            Mail::send('backend.email.user_email', $mail_data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Welcome '.$to_name);
                $message->from('atyourservice@epicmusicla.com','Epic Musicala');
            });
            //CLient Mail Send
            Mail::send('backend.email.client_email', $mail_data, function($client_message) use ($to_name) {
                $client_message->to('epicmusicla@gmail.com', $to_name)->subject('Contact Request From '.$to_name);
                $client_message->from('atyourservice@epicmusicla.com','Epic Musicala');
                // contact@epicmusicla.com
            });
            Toastr::success('','Thank You For Your Message');
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error($e->getMessage(), 'Sorry');
            return redirect()->back();
        }
    }

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
