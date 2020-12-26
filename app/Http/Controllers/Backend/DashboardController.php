<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Brian2694\Toastr\Facades\Toastr;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Seo;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        // $data['seos'] = Seo::all();
        return view('backend.dashboard', $data);
    }
}
