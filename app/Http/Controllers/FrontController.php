<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Seo;
use App\OurTeam;
use App\Video;
use App\Category;
use App\OurExpertise;
use App\Slider;
use App\EpickArtists;

use App\Philanthropy;
use App\EducationInternship;
use App\NewAlbum;
use App\News;
use App\SubmitMusic;
use App\ClientSays;
use App\MusicSportsAwards;
use App\MusicSportsAwardsMenu;
use App\Sports;
use App\Drtv;
use App\SiteSetting;
use App\InterestWorking;
use App\Credit;
use DB;
use App\SportMusic;
use App\SportArtist;
class FrontController extends Controller
{
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $data['our_expertise'] = OurExpertise::where('status',1)->orderBy('sort', 'asc')->get();
        $data['sliders'] = Slider::where('status',1)->orderBy('sort', 'asc')->get();
        $data['credits'] = Credit::where('status',1)->orderBy('sort','asc')->get();
        $data['credit_title_subtitle'] = SiteSetting::where('key','credit')->first();
        $data['credit_status'] = SiteSetting::where('key','credit_status')->first();
        $data['title'] = 'Home';
        $data['seo'] = Seo::where('menu_name', 'home')->first();
        $data['menu'] = 'home';
        return view('home', $data);
    }
    /**
     * Show the application home. 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function our_team()
    {
        $data['our_teams'] = OurTeam::where('status',1)
                                        ->orderBy('sort', 'asc')->get();
        $data['title'] = 'Our Team';
        $data['menu'] = 'our_team';
        $data['seo'] = Seo::where('menu_name', 'our_team')->first();
        return view('our_team', $data);
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function artist()
    {
        $data['epic_artists'] = EpickArtists::where('status',1)
                                            ->orderBy('sort', 'asc')->get();

        $data['title'] = 'Artist';
        $data['menu'] = 'artist';
        $data['seo'] = Seo::where('menu_name', 'artist')->first();
        return view('artist', $data);
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function philanthropy()
    {
        $data['title'] = 'Philanthropy';
        $data['menu'] = 'philanthropy';
        $data['seo'] = Seo::where('menu_name', 'philanthropy')->first();
        $data['lists'] = Philanthropy::orderBy('sort','asc')->get();
        $data['heading_one'] = SiteSetting::where('key','heading_one')->first();
        $data['opacity_one'] = SiteSetting::where('key','opacity_one')->first();
        return view('philanthropy', $data);
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function giving_back()
    {
        $data['title'] = 'Giving Back';
        $data['menu'] = 'giving_back';
        $data['seo'] = Seo::where('menu_name', 'giving_back')->first();
        $data['lists'] = EducationInternship::orderBy('sort','asc')->get();
        $data['interested_in_working'] = InterestWorking::orderBy('sort','asc')->get();
        return view('giving_back', $data);
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function why_epic()
    {
        $data['title'] = 'Why Epic';
        $data['menu'] = 'why_epic';
        $data['client_says'] = ClientSays::where('status',1)->orderBy('sort','desc')->get();
        $data['seo'] = Seo::where('menu_name', 'why_epic')->first();
        return view('why_epic', $data);
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function award_winners_2017()
    {
        $data['title'] = '2017 award winners';
        $data['menu'] = 'award_winners_2017';
        $data['seo'] = Seo::where('menu_name', '2017_award_winners')->first();
        return view('award_winners_2017', $data);
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function music_submit()
    {
        $data['title'] = 'Music Submit';
        $data['menu'] = 'music_submit';
        $data['seo'] = Seo::where('menu_name', 'music_submit')->first();
        $data['submit_music'] = SubmitMusic::first();
        return view('music_submit', $data);
    }

    public function credit()
    {
        $credit_status = SiteSetting::where('key','credit_status')->first();
        if(isset($credit_status) && $credit_status->value !=1){
            return redirect()->back();
        }
        $data['title'] = 'Credit';
        $data['menu'] = 'credit';
        $data['seo'] = Seo::where('menu_name', 'credits')->first();
        $data['credits'] = Credit::where('status',1)->orderBy('sort','asc')->get();
        $data['title_subtitle'] = SiteSetting::where('key','credit')->first();
        return view('credit', $data);
    }
    

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact_us()
    {
        $data['title'] = 'Contact Us';
        $data['menu'] = 'contact_us';
        $data['seo'] = Seo::where('menu_name', 'contact_us')->first();
        $data['contact_us_phone'] = SiteSetting::where('key', 'contact_us_phone')->select('value')->first();
        $data['contact_us_email'] = SiteSetting::where('key', 'contact_us_email')->select('value')->first();
        $data['contact_us_address'] = SiteSetting::where('key', 'contact_us_address')->select('value')->first();
        return view('contact_us', $data);
    }

    public function get_epic_info($epicId){
        $data['epic_artists_info'] = EpickArtists::with('track_lists')->where('status',1)
                                            ->orderBy('sort','asc')->find($epicId);
        $currentsort= EpickArtists::where('id', $epicId)->first();
        $sort=$currentsort->sort;
        $next = EpickArtists::where('sort', '>', $sort)->where('status',1)->orderBy('sort','asc')->first();
        $preview = EpickArtists::where('sort', '<', $sort)->where('status',1)->orderBy('sort','desc')->first();
        if(is_null($next)){
            $data['next_data'] = null;
        }else{
            $data['next_data'] = $next->id;
        }
        if(is_null($preview)){
            $data['prev_data'] = null;
        }else{
            $data['prev_data'] = $preview->id;
        }
        echo json_encode($data);
        // return $epic_artists_info;
    }

    public function get_dr_tv_info($dr_tv_id){
        $data['dr_tv_info'] = Drtv::with('dr_tv_track_lists')->where('status',1)
                                            ->orderBy('sort','asc')->find($dr_tv_id);
        $currentsort= Drtv::where('id', $dr_tv_id)->first();
        $sort=$currentsort->sort;
        $next = Drtv::where('sort', '>', $sort)->where('status',1)->orderBy('sort','asc')->first();
        $preview = Drtv::where('sort', '<', $sort)->where('status',1)->orderBy('sort','desc')->first();
        if(is_null($next)){
            $data['next_data'] = null;
        }else{
            $data['next_data'] = $next->id;
        }
        if(is_null($preview)){
            $data['prev_data'] = null;
        }else{
            $data['prev_data'] = $preview->id;
        }
        echo json_encode($data);
    }

    public function news_and_events()
    {
        $data['title'] = ' News And Events';
        $data['menu'] = 'news_and_events';
        $data['news'] = News::where('status',1)->orderBy('sort','DESC')->get();
        $data['seo'] = Seo::where('menu_name', 'news')->first();
        return view('news_and_events', $data);
    }

    public function single_news($url)
    {
        $data['title'] = ' News And Events';
        $data['menu'] = 'single_news';
        $data['single_news'] = News::where('url',$url)->first();
        $data['seo'] = Seo::where('menu_name', 'news')->first();
        return view('single_news', $data);
    }

    public function award($award_url)
    {
        $data['title'] = $award_url;
        $data['menu'] = 'award_winners_2017';
        $menu_id = MusicSportsAwardsMenu::where('url_link',$award_url)->select('id')->first();
        $data['music_awards'] = MusicSportsAwards::where('music_sports_awards_menus_id',$menu_id->id)->get();
        if(!$data['music_awards']->count()){
            return redirect()->back();
        }
        $data['seo'] = Seo::where('menu_name', 'award')->first();
        return view('music_sports_awards', $data);
    }

    public function sports_music_library()
    {
        $data['title'] = "Sports Our Speciality";
        $data['menu'] = 'sports_our_speciality';
        $data['sports_our_speciality'] = Sports::where('status',1)->orderBy('sort','asc')->get();
        $data['sports_artist'] = SportArtist::where('status',1)->orderBy('sort','asc')->get();
        $data['seo'] = Seo::where('menu_name', 'sports_music_library')->first();
        return view('sports_our_speciality', $data);
    }
     public function get_sports_artist_info($id){
        $data['sports_artist_info'] = SportArtist::with('sports_artist_track_lists')->where('status',1)
                                            ->orderBy('sort','asc')->find($id);
        $currentsort= SportArtist::where('id', $id)->first();
        $sort=$currentsort->sort;
        $next = SportArtist::where('sort', '>', $sort)->where('status',1)->orderBy('sort','asc')->first();
        $preview = SportArtist::where('sort', '<', $sort)->where('status',1)->orderBy('sort','desc')->first();
        if(is_null($next)){
            $data['next_data'] = null;
        }else{
            $data['next_data'] = $next->id;
        }
        if(is_null($preview)){
            $data['prev_data'] = null;
        }else{
            $data['prev_data'] = $preview->id;
        }
        echo json_encode($data);
        
    }


    public function dr_tv()
    {
        $data['title'] = 'DR TV';
        $data['menu'] = 'dr_tv';
        $data['dr_tv'] = Drtv::where('status',1)->orderBy('sort', 'asc')->get();
        $data['seo'] = Seo::where('menu_name', 'dr_tv')->first();
        return view('dr_tv', $data);
    }
    public function exper()
    {
        $seo=DB::table('seos')->first();
        $our_expertise =DB::table('our_expertises')->get();
        return  view('include.home.our_exper',compact('seo','our_expertise'));

    }
    public function all_credit()
    {
       $data['our_expertise'] = OurExpertise::where('status',1)->orderBy('sort', 'asc')->get();
        $data['sliders'] = Slider::where('status',1)->orderBy('sort', 'asc')->get();
        $data['credits'] = Credit::where('status',1)->orderBy('sort','asc')->limit(28)->get();
        $data['credit_title_subtitle'] = SiteSetting::where('key','credit')->first();
        $data['credit_status'] = SiteSetting::where('key','credit_status')->first();
        $data['title'] = 'Home';
        $data['seo'] = Seo::where('menu_name', 'home')->first();
        $data['menu'] = 'home';
        return view('include.home.credit', $data);

    }
    public function all_teams()
    {
        $data['our_teams'] = OurTeam::where('status',1)
                                        ->orderBy('sort', 'asc')->get();
        $data['title'] = 'Our Team';
        $data['menu'] = 'our_team';
        $data['seo'] = Seo::where('menu_name', 'our_team')->first();
        return view('include.team.our_team', $data);
    }
    public function main_credit()
    {
        $data['our_expertise'] = OurExpertise::where('status',1)->orderBy('sort', 'asc')->get();
        $data['sliders'] = Slider::where('status',1)->orderBy('sort', 'asc')->get();
        $data['credits'] = Credit::where('status',1)->orderBy('sort','asc')->paginate(28);
        $data['title_subtitle'] = SiteSetting::where('key','credit')->first();
        $data['credit_status'] = SiteSetting::where('key','credit_status')->first();
        $data['title'] = 'Home';
        $data['seo'] = Seo::where('menu_name', 'home')->first();
        $data['menu'] = 'home';
        return view('include.credits.all_credit', $data); 
    }
    // public function all_awards($award_url)
    // {
    //     $data['title'] = $award_url;
    //     $data['menu'] = 'award_winners_2017';
    //     $menu_id = MusicSportsAwardsMenu::where('url_link',$award_url)->select('id')->first();
    //     $data['music_awards'] = MusicSportsAwards::where('music_sports_awards_menus_id',$menu_id->id)->get();
    //     if(!$data['music_awards']->count()){
    //         return redirect()->back();
    //     }
    //     $data['seo'] = Seo::where('menu_name', 'award')->first();
    //     return view('include.award.all_award', $data);
        
    // }
    public function epic_art()
    {
         $data['epic_artists'] = EpickArtists::where('status',1)
                                            ->orderBy('sort', 'asc')->get();

        $data['title'] = 'Artist';
        $data['menu'] = 'artist';
        $data['seo'] = Seo::where('menu_name', 'artist')->first();
        return view('include.epicartist.epic_artist', $data);
    }
       public function home_slider()
    {
        $data['sliders'] = Slider::where('status',1)->orderBy('sort', 'asc')->get();
        return view('include.home.slider', $data);
    }


}