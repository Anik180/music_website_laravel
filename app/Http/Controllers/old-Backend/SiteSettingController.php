<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Exception;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\SiteSetting;

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
            'music_awards' => $request->music_awards
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
				Toastr::warning('Did Not Updated','Sorry');
			}
			
		}
        Toastr::success('Successfully Updated' ,'Success');
		return redirect()->back();
    }
}