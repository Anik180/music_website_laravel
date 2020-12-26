<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use App\SiteSetting;
use App\User;
use Auth;
class SiteSettingController  extends Controller
{
    /**
     * construct of this class
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Site Settings';
        $data['menu'] = 'site_settings';
        $data['configs'] = SiteSetting::all();
        return view('backend.site_settings', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // get logo
		// $logo = $request->file('logo');
        // if(isset($logo)){
        //     $db_logo = SiteSetting::where('key','logo')->first();
        //     $site_logo = 'logo'.uniqid().'.'.$logo->getClientOriginalExtension();
        //     if($db_logo->value != 'default_logo.svg'){
        //         if (Storage::disk('public')->exists('setting/'.$db_logo->value)) {
        //             Storage::disk('public')->delete('setting/'.$db_logo->value);
        //         }
        //     }
        //     Storage::disk('public')->putFileAs('setting', $logo, $site_logo);
        // } else {
        //     $site_logo = $db_logo->value;
		// }
		//get favicon
		// $favicon = $request->file('favicon');
        // if(isset($favicon)){
        //     $db_favicon = SiteSetting::where('key','favicon')->first();
        //     $site_favicon = 'favicon'.uniqid().'.'.$favicon->getClientOriginalExtension();
		// 	if (Storage::disk('public')->exists('setting/'.$db_favicon->value)) {
        //         Storage::disk('public')->delete('setting/'.$db_favicon->value);
		// 	}
        //     Storage::disk('public')->putFileAs('setting', $favicon, $site_favicon);
		// } else {
        //     $site_favicon = $db_favicon->value;
        // }
        // array
        $logo_data = SiteSetting::where('key','logo')->first();
        $icon_data = SiteSetting::where('key','favicon')->first();
        if($request->file('logo')){
            $logo = $request->file('logo');
            if($logo_data->value){
                if (Storage::disk('public')->exists('uploads/siteSetting/'.$logo_data->value)) {
                    Storage::disk('public')->delete('uploads/siteSetting/'.$logo_data->value);
                }
            }
            $logo_file_name = uniqid().'.'.$logo->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('uploads/siteSetting', $logo, $logo_file_name);
        } else {
            $logo_file_name = $logo_data->value;
        }

        if($request->file('favicon')){
            $favicon = $request->file('favicon');
            if($icon_data->value){
                if (Storage::disk('public')->exists('uploads/siteSetting/'.$icon_data->value)) {
                    Storage::disk('public')->delete('uploads/siteSetting/'.$icon_data->value);
                }
            }
            $icon_file_name = uniqid().'.'.$favicon->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('uploads/siteSetting', $favicon, $icon_file_name);
        } else {
            $icon_file_name = null;
        }
        $arr_data = array(
  		  'site_name' => $request->site_name,
  		  'logo' =>  $logo_file_name,
  		  'favicon' =>  $icon_file_name,
            'header_phone' => $request->header_phone,
            'contact_us_phone' => $request->contact_us_phone,
            'contact_us_email' => $request->contact_us_email,
            'contact_us_address' => $request->contact_us_address,
            // 'contact_us_map' => $request->contact_us_map,
            'footer_phone' => $request->footer_phone,
            'footer_us_email' => $request->footer_us_email,
            'footer_us_address' => $request->footer_us_address,
            'facebook_url' => $request->facebook_url,
            'linkedin_url' => $request->linkedin_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'dr_tv' => $request->dr_tv,
            'music_awards' => $request->music_awards,
            'credit_status' => $request->credit_status,
            'heading_one' => $request->heading_one,
            'opacity_one' => $request->opacity_one
        );
    // updating or inserting
		foreach($arr_data as $key=>$val) {
			try {
				if(SiteSetting::where('key',$key)->exists()) {
					$result=SiteSetting::where('key', $key)->update(['value' => $val]);
				} else {
					$config['key'] = $key;
					$config['value'] = $val;
					$result=SiteSetting::insert($config);
				} 
			} catch (Exception $e) {
				$notification=array(
               'messege'=>'Sorry!',
               'alert-type'=>'error'
                );
   return Redirect()->back()->with($notification);
			}
			
		}
        
$notification=array(
          'messege'=>'Successfully Updated',
           'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
    }

    public function change_password(){
        $data['title'] = 'Change Password';
        $data['menu'] = 'change_password';
        return view('backend.change_password', $data);
    }

    public function password_change(Request $request){
        if (!(Hash::check($request->get('old_pass'), Auth::user()->password))) {

            $notification=array(
            'messege'=>'Your current password does not matches with the password you provided. Please try again.',
            'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }

        if(strcmp($request->get('old_pass'), $request->get('new_pass')) == 0){
            $notification=array(
            'messege'=>'New Password cannot be same as your current password. Please choose a different password.',
            'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }
        if($request->new_pass != $request->con_pass){
             $notification=array(
            'messege'=>'Password Confirmation Failed',
            'alert-type'=>'error'
             );
   return Redirect()->back()->with($notification);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->get('new_pass'));
        $user->save();
           $notification=array(
            'messege'=>'Successfully Password Changed',
            'alert-type'=>'success'
             );
   return Redirect()->back()->with($notification);
    }

}