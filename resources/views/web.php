<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ---------------------------------------
/ Frontend controller
--------------------------------------- */
Route::get('/', 'FrontController@index');
Route::get('/our-team', 'FrontController@our_team');
Route::get('/artist', 'FrontController@artist');
Route::get('/philanthropy', 'FrontController@philanthropy');
Route::get('/giving-back', 'FrontController@giving_back');
Route::get('/why-epic', 'FrontController@why_epic');
Route::get('/awards/{award_url}', 'FrontController@award');
Route::get('/music-submit', 'FrontController@music_submit');
Route::get('/contact-us', 'FrontController@contact_us');
Route::post('/contact-us','Backend\ContactUsController@store');
Route::get('/get-epic-artists-info/{epicId}', 'FrontController@get_epic_info');
Route::get('/get-dr-tv-info/{dr_tv_id}', 'FrontController@get_dr_tv_info');
Route::get('/news-and-events', 'FrontController@news_and_events');
Route::get('/news/{url}', 'FrontController@single_news');
Route::get('/sports-our-speciality', 'FrontController@sports_our_speciality');
Route::get('/dr-tv', 'FrontController@dr_tv');
// Route::get('/awards/{url}', 'FrontController@music_sports_awards');


/* ---------------------------------------
/ Backend controller
--------------------------------------- */

Route::prefix('admin')->group(function () {
    Auth::routes();
});
Route::middleware(['auth'])
    ->namespace('Backend')
    ->prefix('admin')->group(function () {
    Route::get('/dashboard', function(){
        return redirect('admin/slider');
    });
    // home
    Route::resource('/slider', 'SliderController');
    Route::post('slider/update','SliderController@update');
    // experties (dynamic from SEO Section)
    // pictures & links
    Route::resource('our-expertise','OurExpertiseController');
    Route::post('our-expertise/image-update','OurExpertiseController@image_update');
    Route::get('our-expertise-download-image/{image}','OurExpertiseController@download_image');
    Route::post('our-expertise-sort','OurExpertiseController@sort_update');
    Route::post('our-expertise-update','OurExpertiseController@update');
    // about team (dynamic from SEO Section)
    // our-team
    Route::resource('/our-team', 'OurTeamController');
    Route::post('our-team/update','OurTeamController@update');
    Route::get('our-team-download-image/{image}','OurTeamController@download_image');
    Route::post('our-team/image-update','OurTeamController@image_update');
    Route::post('our-team-sort','OurTeamController@sort_update');
    // about epicArtists (dynamic from SEO Section)
    // epicArtists
    Route::resource('/epicArtists', 'EpicArtistsController');
    Route::post('epicArtists/update','EpicArtistsController@update');
    Route::post('epic-artist-sort','EpicArtistsController@sort_update');
    Route::post('epic-artist/image-upload','EpicArtistsController@image_update');
    // epicArtists track
    Route::get('epic-artists/track-list/{epic_id}','EpicArtistsController@track_list');
    Route::post('epic-artists/track-list-store','EpicArtistsController@track_list_store');
    Route::post('epic-artists/track-list-update','EpicArtistsController@track_list_update');
    Route::post('epic-artists/track-list-delete/{id}','EpicArtistsController@track_list_delete');
    Route::post('epic-artists/track-list-music-upload','EpicArtistsController@track_list_music_upload');
    Route::get('get-epicArtistsId-data','EpicArtistsController@get_epicArtists');
    // giving back
    // philanthropy
    Route::resource('/philanthropies', 'PhilanthropyController');
    Route::post('/philanthropies-sort-update', 'PhilanthropyController@sort_update');
    // education internships
    Route::resource('/education-internships', 'EducationInternshipsController');
    Route::post('/education-internships-sort-update', 'EducationInternshipsController@sort_update');
    Route::post('/education-internships/image-update', 'EducationInternshipsController@image_update');
    // seo
    Route::resource('/seos', 'SeoController');
    Route::get('/seo-show', 'SeoController@seo_show');
    Route::put('/seo-update/{menu}', 'SeoController@seo_update');
    // site setting
    Route::resource('site-settings', 'SiteSettingController');

    //New Album
    Route::resource('new-album','NewAlbumController');
    Route::post('new-album/update','NewAlbumController@update');
    Route::post('new-album/delete/{id}','NewAlbumController@destroy');
    Route::post('new-album-sort','NewAlbumController@sort_update');
    Route::post('new-album-image-update','NewAlbumController@image_update');

    Route::get('news-list','NewsController@index');
    Route::get('news-create','NewsController@create');
    Route::post('news-create','NewsController@store');
    Route::post('news-sort','NewsController@sort_update');
    Route::get('news-edit/{id}','NewsController@edit');
    Route::post('news-update/{id}','NewsController@update');
    Route::post('news/delete/{id}','NewsController@destroy');
    Route::post('news-image-update','NewsController@image_update');

    Route::get('submit-music','SubmitMusicController@index');
    Route::post('submit-music/update','SubmitMusicController@update');

    //Music Sports Awards Menu
    Route::get('music-sports/menu','MusicSportsAwardsController@index');
    Route::post('music-sports-awards-menu-store','MusicSportsAwardsController@store');
    Route::post('submit-sports-award-menu-update','MusicSportsAwardsController@update');
    Route::post('music-sports-awards-menu-destroy/{id}','MusicSportsAwardsController@destroy');
    Route::post('submit-sports-award-menu-sort','MusicSportsAwardsController@award_menu_sort_update');

    //Music sports awards
    Route::get('submit-sports/awards-list/{menu_id}','MusicSportsAwardsController@awards_list');
    Route::post('music-sports-awards-store','MusicSportsAwardsController@awards_store');
    Route::post('submit-sports-award-sort','MusicSportsAwardsController@awards_sort_update');
    Route::post('submit-sports-award-update','MusicSportsAwardsController@awards_update');
    Route::post('music-sports-awards-destroy/{id}','MusicSportsAwardsController@awards_destroy');

    //Why Epic
    Route::get('why-epic-list','WhyEpicController@index');
    Route::get('why-epic-create','WhyEpicController@create');
    Route::post('why-epic-create','WhyEpicController@store');
    Route::get('why-epic-edit/{id}','WhyEpicController@edit');
    Route::post('why-epic-update/{id}','WhyEpicController@update');
    Route::post('why-epic-delete/{id}','WhyEpicController@destroy');

    //CLinet Say
    Route::get('why-epic/client-say','ClientSayController@index');
    Route::post('why-epic/client-say-store','ClientSayController@store');
    Route::post('why-epic/client-say-update','ClientSayController@update');
    Route::post('why-epic/client-say-sort','ClientSayController@sort_update');
    Route::post('why-epic/client-say-delete/{id}','ClientSayController@destroy');

    //Sports
    Route::get('sports','SportController@index');
    Route::post('sports','SportController@store');
    Route::post('sports-update','SportController@update');
    Route::post('sort-update','SportController@sort_update');
    Route::post('sports-image-update','SportController@image_update');
    Route::post('sports-destroy/{id}','SportController@destroy');

    Route::get('dr-tv','DrtvController@index');
    Route::post('dr-tv-store','DrtvController@store');
    Route::post('dr-tv-sort','DrtvController@sort_update');
    Route::post('dr-tv-update','DrtvController@update');
    Route::post('dr-tv-delete/{id}','DrtvController@destroy');
    Route::post('dr-tv-image-upload','DrtvController@image_update');

    Route::get('dr-tv/music/{id}','DrtvController@music_list');
    Route::post('dr-tv/music-store','DrtvController@music_store');
    Route::post('dr-tv/music-update','DrtvController@music_update');
    Route::post('dr-tv/music-delete/{id}','DrtvController@music_delete');
    Route::post('dr-tv/music-upload','DrtvController@music_upload');


    // Route::resource('/aboutUs', 'AboutUsController');
    // Route::post('aboutUs/update','AboutUsController@update');
    // Route::resource('/cardSection', 'CardSectionController');
    // Route::post('cardSection/update','CardSectionController@update');
    // Route::resource('contact-us','ContactUsController');

});



/* ---------------------------------------
/ Artisan Command
--------------------------------------- */
//to clear all cache
Route::get('__clear',function(){
    try{
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        \Artisan::call('route:clear');
    }
    catch(\Exception $e){
        echo $e->getMessage();
    }
});

// Route::get('__storage',function(){
//     try{
//         \Artisan::call('storage:link');
//     	dd(\Artisan::output());
//     }
//     catch(\Exception $e){
//         echo $e->getMessage();
//     }
// });