<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class AboutdrtvController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function aboutdrtv()
    {
        $data['title'] = 'DR TV'; 
        $data['menu'] = 'dr_tv';
        $data['sub_menu'] = 'about_drtv';
       	$data['drtv'] = DB::table('aboutdrtvs')->first();
	    return view('backend.aboutdrtv',$data);

    }
    public function updateaboutdrtv(Request $request,$id)
    {
      $data=array();
      $data['title']=$request->title;
      $data['description']=$request->description;
      DB::table('aboutdrtvs')->where('id',$id)->update($data);
        $notification=array(
            'messege'=>'Successfully update',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function teamaboutdrtv()
    {
        $data['menu'] = 'dr_tv';
        $data['sub_menu'] = 'drtv_team';
        $data['drtvteam'] = DB::table('teamdrtvs')->first();
        return view('backend.teamdrtv',$data);
    }
    public function updateteamdrtv(Request $request,$id)
    {
        $data=array();
        $data['title']=$request->title;
        $data['description']=$request->description;
        DB::table('teamdrtvs')->where('id',$id)->update($data);
        $notification=array(
          'messege'=>'Successfully update',
           'alert-type'=>'success'
             );
        return Redirect()->back()->with($notification);
    }
    public function updatedrtv(Request $request,$id)
    {
        $data=array();
        $data['title']=$request->title;
        $data['about']=$request->about;
        $data['description']=$request->description;
        $data['here_more_url']=$request->here_more_url;
        $data['status']=$request->status;
        DB::table('drtvs')->where('id',$id)->update($data);
        $notification=array(
            'messege'=>'Successfully update',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function drtvpart()
    {
        $data['menu'] = 'dr_tv';
        $data['sub_menu'] = 'drtv_pratner';
       	$data['drtvpart'] =DB::table('drtvpartners')->first();
	    return view('backend.drtvpartner',$data);

    }
    public function updatedrtvpart(Request $request,$id)
    {
        $data=array();
        $data['title']=$request->title;
        $data['description']=$request->description;
        DB::table('drtvpartners')->where('id',$id)->update($data);
        $notification=array(
            'messege'=>'Successfully update',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function sportsteam()
    {
        $data['menu'] = 'sports';
        $data['sub_menu'] = 'composer_sports';
    	$data['sportsteam'] =DB::table('sport_teams')->first();
	    return view('backend.sports_team',$data);
    }
    
    public function updatesportsteam(Request $request,$id)
    {
        $data=array();
        $data['title']=$request->title;
        $data['description']=$request->description;
        DB::table('sport_teams')->where('id',$id)->update($data);
        $notification=array(
            'messege'=>'Successfully update',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function sportsartis_update(Request $request,$id)
    {   
      $data=array();
      $data['title']=$request->title;
      $data['about']=$request->about;
      $data['description']=$request->description;
      $data['here_more_url']=$request->here_more_url;
      $data['status']=$request->status;
      DB::table('sport_artists')->where('id',$id)->update($data);
$notification=array(
          'messege'=>'Successfully update',
           'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
    }
}
