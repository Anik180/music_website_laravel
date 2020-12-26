@php
$data = [];
$siteSetting = \App\SiteSetting::all();
foreach($siteSetting as $site_data)
$data[$site_data->key] = $site_data->value;
@endphp
<!DOCTYPE html>
<html lang="en">
   <head>
      
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="HandheldFriendly" content="True">
      <meta name="MobileOptimized" content="320">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
      <meta name="google-site-verification" content="VL7cBNEpE2eo7RItylBc9hUCK9ZVXJqMUzEUC9rU4Lc" />
      <link rel="shortcut icon" href="{{ ($data['favicon'])? asset(config('app.f_url').'/storage/app/public/uploads/siteSetting/'.$data['favicon']):asset('public/assets/images/fav.png') }}" type="image/x-icon">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta name="keywords" content="{!! isset($seo->seo_keywords)?$seo->seo_keywords:'404 Not Found'!!}">
      <meta name="image" content="{{ URL::to('assets/img/paribahanhishab.jpg') }}">
      <!-- Schema.org for Google -->
      <meta itemprop="name" content="{!! isset($seo->seo_title)?$seo->seo_title:'404 Not Found' !!}">
      <meta itemprop="description" content="{!! isset($seo->seo_desc)?$seo->seo_desc:'404 Not Found'!!}">
      <meta itemprop="image" content="{{ URL::to('assets/img/paribahanhishab.jpg') }}">
      @yield('meta')
      <link rel="icon" href="{{ URL::to('assets/img/favicon.png') }}" type="image/x-icon" />
      {{-- <title>{!! isset($seo->meta_title)?$seo->meta_title:'404 Not Found' !!}</title> --}}
      @if (\Request::is('news/*')) 
      @else
      <title>{!! isset($seo->meta_title)?$seo->meta_title:'404 Not Found' !!}</title>
      @endif
      @if (\Request::is('news/*')) 
      @else
      <meta name="description" content="{!! isset($seo->meta_desc)?$seo->meta_desc:'404 Not Found'!!}">
      <meta name="keywords" content="{!! isset($seo->meta_key)?$seo->meta_key:'404 Not Found'!!}">
      <link rel="canonical" href="{{ url('/') }}">
      <!-- Open Graph general -->
      <meta property="og:locale" content="en_US" />
      <meta property="og:type" content="website" />
      <meta property="og:title" content="{!! isset($seo->meta_title)?$seo->meta_title:'404 Not Found' !!}" />
      <meta property="og:description" content="{!! $seo->meta_desc !!}" />
      <meta property="og:url" content="{{ url()->current() }}" />
      <meta property="og:image" content="https://epicmusicla.com/wp-content/uploads/2017/09/Balls-Sports.jpg" />
      <meta property="og:image:secure_url" content="https://epicmusicla.com/wp-content/uploads/2017/09/Balls-Sports.jpg" />
      <meta property="og:image:width" content="660" />
      <meta property="og:image:height" content="338" />
      {{-- 
      <meta property="og:site_name" content="Epic Music Production" />
      --}}
      <meta property="og:image:alt" content="image alte text" />
      {{-- 
      <meta property="fb:app_id" content="244074169935606" />
      --}}
      <!-- twitter -->
      <meta name="twitter:card" content="summary" />
      {{-- 
      <meta name="twitter:url" content="{{ url()->current() }}" />
      --}}
      <meta name="twitter:description" content="{!! isset($seo->meta_desc)?$seo->meta_desc:'404 Not Found'!!}">
      <meta name="twitter:title" content="{!! isset($seo->meta_title)?$seo->meta_title:'404 Not Found' !!}">
      {{-- 
      <meta name="twitter:site" content="@epicmusicla" />
      --}}
      <meta name="twitter:image" content="{{ URL::to('public/assets/img/paribahanhishab.jpg') }}">
      {{-- 
      <meta name="twitter:image:alt" content="paribahanhisahb.com" />
      --}}
      <meta name="twitter:creator" content="@epicmusicla">
      @endif
      <!--GoDaddy Security Badge-->
      <script id="godaddy-security-s" src="https://cdn.sucuri.net/badge/badge.js" data-s="206" data-i="f621ac68e9e05c9f79744af21aaa0fed91257e8c4a" data-p="r" data-c="d" data-t="g"></script>
      <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
      <script src="https://use.fontawesome.com/455ee3e1a7.js"></script>
      <script src="{{ asset('public/assets/scripts/vendor/modernizr.js') }}"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
      <!-- animation css -->
      <!-- <link rel="stylesheet" href="http://s.mlcdn.co/animate.css"> -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://www.google.com/recaptcha/api.js"></script>
      {{-- <script>
         $(document).ready(function(){
            $(function() {
               var pgurl = window.location.href.substr(window.location.href);
               $("ul.nav.navbar-nav.navbar-right li a").each(function(){
                  if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
                     $(this).addClass("active");
               })
            });
         });
      </script> --}}
      <style>
         audio {
         margin-left: 15px;
         }
         table.music-table tr td {
         vertical-align: middle;
         }
         img.artist-details-img {
         border-radius: 15px;
         }
      </style>
      {{-- 
      <link rel="stylesheet" id="easy-wp-page-nav-css"  href="https://epicmusicla.com/wp-content/plugins/easy-wp-page-navigation//css/easy-wp-pagenavigation.css?ver=1.1" type="text/css" media="all" />
      --}}
      <link rel="stylesheet" id="main-style-css"  href="{{ asset('public/assets/styles/main.css?ver=5.2.5') }}" type="text/css" media="all" />
      {{-- 
      <link rel="stylesheet" id="style-css"  href="https://epicmusicla.com/wp-content/themes/epicmusicla/style.css?ver=5.2.5" type="text/css" media="all" />
      --}}
      <link rel="stylesheet" id="color-yellow-css"  href="{{ asset('public/assets/styles/colors/color-yellow.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="color-lightblue-css"  href="{{ asset('public/assets/styles/colors/color-lightblue.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="color-purple-css"  href="{{ asset('public/assets/styles/colors/color-purple.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="color-green-css"  href="{{ asset('public/assets/styles/colors/color-green.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="color-militar-css"  href="{{ asset('public/assets/styles/colors/color-militar.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="color-caqui-css"  href="{{ asset('public/assets/styles/colors/color-caqui.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="color-red-css"  href="{{ asset('public/assets/styles/colors/color-red.css?ver=5.2.5') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="elementor-icons-css"  href="{{ asset('public/assets/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css?ver=5.3.0') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="elementor-animations-css"  href="{{ asset('public/assets/plugins/elementor/assets/lib/animations/animations.min.css') }}" type="text/css" media="all" />
      <link rel="stylesheet" id="elementor-frontend-css"  href="{{ asset('public/assets/plugins/elementor/assets/css/templates/frontend.min.css') }}" type="text/css" media="all" />
      {{-- 
      <link rel="stylesheet" id="elementor-global-css"  href="{{asset('/global.css?ver=1566203112')}}" type="text/css" media="all" />
      --}}
      {{-- 
      <link rel="stylesheet" id="pfcf-style-css"  href="https://epicmusicla.com/wp-content/plugins/popup-for-contact-form-7/css/pfcf-style.css?ver=5.2.5" type="text/css" media="all" />
      --}}
      {{-- 
      <link rel="stylesheet" id="cf7cf-style-css"  href="https://epicmusicla.com/wp-content/plugins/cf7-conditional-fields/style.css?ver=1.6.4" type="text/css" media="all" />
      --}}
      <link rel="stylesheet" id="google-fonts-1-css"  href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;ver=5.2.5" type="text/css" media="all" />
      @yield('css')
      {{-- <script>if (document.location.protocol != "https:") {document.location = document.URL.replace(/^http:/i, "https:");}</script><script type='text/javascript'>
         /* <![CDATA[ */
         var monsterinsights_frontend = {"js_events_tracking":"true","download_extensions":"doc,pdf,ppt,zip,xls,docx,pptx,xlsx","inbound_paths":"[{\"path\":\"\\\/go\\\/\",\"label\":\"affiliate\"},{\"path\":\"\\\/recommend\\\/\",\"label\":\"affiliate\"}]","home_url":"https:\/\/epicmusicla.com","hash_tracking":"false"};
         /* ]]> */
         
      </script> --}}
      {{-- <script type="text/javascript" src="https://epicmusicla.com/wp-content/plugins/google-analytics-for-wordpress/assets/js/frontend.min.js?ver=7.10.0"></script>
      <script type="text/javascript" src="https://epicmusicla.com/wp-includes/js/jquery/jquery.js?ver=1.12.4-wp"></script>
      <script type="text/javascript" src="https://epicmusicla.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1"></script>
      <script type="text/javascript" src="https://epicmusicla.com/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4"></script>
      <script type="text/javascript" src="https://epicmusicla.com/wp-content/plugins/mega-addons-for-visual-composer/js/script.js?ver=5.2.5"></script>
      <script type="text/javascript" src="https://epicmusicla.com/wp-content/plugins/popup-for-contact-form-7/js/pfcf-script.js?ver=5.2.5"></script>
      <link rel="https://api.w.org/" href="https://epicmusicla.com/wp-json/" />
      <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://epicmusicla.com/xmlrpc.php?rsd" />
      <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://epicmusicla.com/wp-includes/wlwmanifest.xml" />
      <meta name="generator" content="WordPress 5.2.5" />
      <link rel="shortlink" href="https://epicmusicla.com/" />
      <link rel="alternate" type="application/json+oembed" href="https://epicmusicla.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fepicmusicla.com%2F" />
      <link rel="alternate" type="text/xml+oembed" href="https://epicmusicla.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fepicmusicla.com%2F&#038;format=xml" />
      --}}
      <script type="text/javascript">
         (function () {
            window.lvca_fs = {can_use_premium_code: false};
         })();
      </script>
      <style type="text/css" id="custom-background-css">
         body.custom-background {
         background-color: #ffffff;
         }
      </style>
      <style type="text/css" id="wp-custom-css"> .elementor {
         background: #fff;
         }
         .shodow-btn .elementor-widget-container .elementor-button-wrapper a {
         box-sizing: border-box;
         box-shadow: 5px 5px rgba(0, 0, 0, 1);
         }
         .shodow-btn .elementor-widget-container .elementor-button-wrapper a:hover {
         box-sizing: border-box;
         box-shadow: none;
         }
         img.fullImage {
         width: 100%;
         float: none;
         }
         div.wpcf7-mail-sent-ok {
         border: 2px solid #398f14;
         background: #fff;
         }
         footer {
         background-image: none!important;
         background-color: #111;
         }
         .footer-sl {
         float: left;
         }
         ul.contact li {
         margin: 0px;
         color: #fff;
         font-size: 15px;
         display: inline-flex;
         font-weight: 700;
         }
         .footer-sl h4.title.small {
         font-size: 25px;
         text-align: left;
         margin-bottom: 15px;
         color: #fff!important;
         }
         .new li {
         display: block;
         margin-right: 125px;
         margin-bottom: 10px;
         color: #519A0A;
         }
         .new li a {
         font-size: 15px;
         font-weight: 700;
         width: 100px;
         text-align: left;
         }
         .palettegreen .social-links a:hover {
         background-color: inherit;
         border-color: #519a0a;
         }
         footer.footer-section a.footer-icons img {
         margin-top: 40px;
         }
         ul.img-gallery li a {
         display: inline-block;
         float: left;
         width: 25%;
         }
         ul.img-gallery li a img {
         width: 800px;
         height: auto;
         padding: 4px;
         }
         @media only screen and (max-width: 767px) {
         .new li a {
         font-size: 12px;
         }
         .footer-sl h4.title.small {
         font-size: 17px;
         text-align: left;
         margin-bottom: 15px;
         color: #fff!important;
         }
         ul.contact li {
         font-size: 12px;
         }
         ul.contact {
         margin: 0px 0px 20px 0px;
         }
         .social-links a {
         width: 28px;
         }
         h4.title.small {
         margin-top: 10px;
         }
         .new li {
         margin-bottom: 0px;
         }
         }
      </style>
      {!! isset($seo->header_code)?$seo->header_code:'' !!}
   </head>
   <body data-spy="scroll" data-target="#navbar-muziq" data-offset="80">
      {!! isset($seo->body_code)?$seo->body_code:'' !!}
      <div class="main-container">
         <div id="mask">
            <div class="loader">
               <div class="cssload-container">
                  <div class="cssload-shaft1"></div>
                  <div class="cssload-shaft2"></div>
                  <div class="cssload-shaft3"></div>
                  <div class="cssload-shaft4"></div>
                  <div class="cssload-shaft5"></div>
                  <div class="cssload-shaft6"></div>
                  <div class="cssload-shaft7"></div>
                  <div class="cssload-shaft8"></div>
                  <div class="cssload-shaft9"></div>
                  <div class="cssload-shaft10"></div>
               </div>
            </div>
         </div>
         <style>
            header.fixed {
            position: fixed;
            }
            .number{
            display: block;
            position: fixed;
            top: 2px;
            left: 332px;
            width: 100%;
            color: #FF6600;
            font-size: 13px;
            }
            @media (max-width:1349px){
            .number{
            top: 20px;
            left: 40%;
            }
            }
            @media (max-width:991px){
            .number{
            top: 20px;
            left: 43%;
            }
            }
            @media (max-width:767px){
            .number{
            top: 20px;
            left: 43%;
            }
            }
         </style>
         <!-- HEADER -->
         <header class="fixed">
            <a style="text-decoration: none;
               color: #FF6600;
               font-size: 12px;
               position: absolute;
               left: 275px;
               top: 2px;
               z-index: 99999999;" href="#" id="audioControl" style="font-weight: bold; color:#white !important;"><del>SOUND</del></a> 
            <span class="number">Call us {{$data['header_phone']}}</span>
            <nav class="navbar navbar-default" role="navigation">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Desplegar navegaci?n</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="{{ url('/') }}"><img class="logo" src="{{ ($data['logo'])? asset(config('app.f_url').'/storage/app/public/uploads/siteSetting/'.$data['logo']) : asset('assets/images/logo.png') }}" alt="logo"/></a>
               </div>
               <div ng-app="" class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-muziq">
                  <script type="text/javascript">
                     $(document).ready(function() {
                         $('a#search').click(function(){
                             if($('.searchbox').val() == ""){
                                 //alert("");
                                 return false;
                             }else {
                                 $('.searchbox').val('');
                                 return true;
                             }
                         });
                         $("#music_search_form").submit(function(e){
                     if($('.searchbox').val() == ""){
                                 //alert("");
                                 return false;
                             }else{
                                 $('#music_search_form').attr('action', "http://www.myepicmusiclibrary.com/#!explorer?s="+$('.searchbox').val());
                                 var url = $(this).prop('action');
                                 window.open(url, '_blank');
                                 $('.searchbox').val('');
                                 e.preventDefault();
                     
                             }
                     });
                     });
                  </script>
                  <ul class="nav navbar-nav navbar-right">
                     <li class="search" style="color:red !important;">
                        <form id="music_search_form" action="">
                           <input type="text" class="searchbox" ng-model="search" name="search" placeholder="Search Our Music">
                        </form>
                        <a id="search" href="http://www.myepicmusiclibrary.com/#!explorer?s=" target="_blank" class="search-btn">
                           <!-- <i class="fa fa-search" aria-hidden="true"></i> -->
                           <img class="search-icon" src="{{ asset('public/assets/images/search.png') }}" alt="">
                        </a>
                     </li>
                  </ul>
                  <ul id="menu-my-menu" class="nav navbar-nav">
                     <li id="menu-item-15" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-10 current_page_item menu-item-15">
                        <a href="{{ url('/') }}" aria-current="page" {{-- class="{{ ($menu=='home')?'active':'' }} --}}>Home</a>
                     </li>
                     <li id="menu-item-70" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-70">
                        <a href="{{ url('/our-team') }}" "class="{{ ($menu=='our_team')?'active':'' }}">Team</a>
                     </li>
                     <li id="menu-item-145" class="dropdown menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-145">
                        <a href="#">Music</a>
                        <ul class="dropdown-content">
                           <li id="menu-item-146" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-146">
                              <a target="_blank" rel="noopener noreferrer" href="http://www.myepicmusiclibrary.com/#!home">Music Production Library</a>
                           </li>
                           <li id="menu-item-148" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-148">
                              <a href="{{ url('/artist') }}">EPIC Artists / Bands</a>
                           </li>
                        </ul>
                     </li>
                     @if(isset($data['credit_status']) && $data['credit_status'] == 1)
                     <li id="menu-item-70" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-70">
                        <a href="{{ url('/credits') }}" class="{{ ($menu=='credit')?'active':'' }}">Credits</a>
                     </li>
                     @endif
                     <li id="menu-item-149" class="dropdown menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-149">
                        <a href="#">Giving Back</a>
                        <ul class="dropdown-content">
                           <li id="menu-item-150" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-150"><a href="{{ url('/philanthropy') }}">PHILANTHROPY</a></li>
                           <li id="menu-item-151" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-151"><a href="{{ url('/giving-back') }}">EDUCATION &amp; INTERNSHIPS</a></li>
                        </ul>
                     </li>
                     <li id="menu-item-152" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-152">
                        <a href="{{ url('/why-epic') }}">Why Epic</a>
                     </li>
                     @if(isset($data['music_awards']) && $data['music_awards'] == 1)
                     <li id="menu-item-427" class="dropdown menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-427">
                        <a href="#">Music+Sports Awards</a>
                        <ul class="dropdown-content">
                           @foreach(\App\MusicSportsAwardsMenu::where('status',1)->orderBy('sort','asc')->get() as $music_menu)
                           <li id="menu-item-595" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-595">
                              <a href="{{url('awards',$music_menu->url_link)}}">{{$music_menu->title}}</a>
                           </li>
                           @endforeach
                        </ul>
                     </li>
                     @endif
                     @if(isset($data['dr_tv']) && $data['dr_tv'] == 1)
                     <li id="menu-item-2534" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2534">
                        <a href="{{ url('/drtv-music') }}">DR Tv</a>
                     </li>
                     @endif
                     <li id="menu-item-2534" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2534">
                        <a href="{{ url('/music-submit') }}">Submit Music</a>
                     </li>
                     <li id="menu-item-153" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-153">
                        <a href="{{ url('/contact-us') }}">Contact Us</a>
                     </li>
                  </ul>
               </div>
            </nav>
         </header>
         @yield('content')
         {{-- @include('include.footer') --}}
         <!-- FOOTER -->
         <style>
            .social-links{
            margin: 0;
            padding: 0;
            }
            ul.img-gallery li a img{
            /*width: 100px;*/
            height: auto !important;
            padding: 0 !important;
            }
            .social-links li, .social-nav li{
            display: block;
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 10px 0;
            text-transform: initial;
            }
            .social-links li i{
            margin-right: 10px;
            color: #519a0a;
            }
            .social, .social-nav{
            margin: 0;
            padding: 0;
            }
            .social li{
            display: inline-block;
            }
            .social li a img{
            height: 40px;
            width: 40px;
            cursor: pointer;
            }
            .social-nav li.active{
            text-decoration: underline;
            }
            .social-nav li a{
            color: #fff;
            margin: 0 0 10px 0;
            }
            ul.img-gallery.footer-all li a img{
            height: 70px;
            transition: 0.5s;
            }
            ul.img-gallery.footer-all li a img:hover {
            transform: scale(1.5);
            }
            @media only screen and (max-width: 767px){
            .footer-sl{
            width: 100%;
            margin: 0 auto;
            text-align: center;
            }
            h4.title.small{
            text-align: center !important;
            font-size: 25px !important;
            }
            }
            .footer-news a{
            display: inline-flex;
            align-items: center;
            margin: 0 0 10px 0;
            }
            .footer-news a h3{
            margin-left: 5px;
            color: #fff;
            }
            .footer-icon {
            display: block;
            float: left;
            padding-top: 5px;
            }
            span.footer-desc {
            display: flex;
            }
         </style>
         @php
         $news_albums = \App\NewAlbum::orderBy('sort', 'asc')->limit(8)->get()
         @endphp
         <footer class="footer-section" style="background-color: #111; padding: 40px 0;">
            <div class="container">
               <div class="row">
                  <div class="col-md-3 col-sm-3 col-xs-12">
                     <div class="footer-news">
                        <a href="{{url('news-and-events')}}">
                           <img width="70" height="70" src="{{ asset('public/assets/images/news-icon-blue.png') }}" title="News and Events">
                           <h3> NEWS AND EVENTS</h3>
                        </a>
                     </div>
                     <div class="footer-sl">
                        <h4 class="title small"  style="color:green;">NEW ALBUMS</h4>
                        <ul class="img-gallery footer-all">
                           @foreach($news_albums as $album)
                           <li>
                              <a style="padding: 2px;" href="{{$album->url}}" target="_blank">
                              <img width="70" height="70" src="{{asset(config('app.f_url').'/storage/app/public/uploads/newAlbum/'.$album->photo)}}" title="{{$album->title}}">
                              </a>
                           </li>
                           @endforeach
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                     <div class="footer-sl">
                        <h4 class="title small"  style="color:green;">IMPORTANT LINKS</h4>
                        <ul class="social-nav">
                           <li class="active">
                              <a href="https://epicmusicla.com/" target="_blank">HOME</a>
                           </li>
                           <li><a href="our-team" target="_blank">OUR TEAM</a></li>
                           <li><a href="https://www.myepicmusiclibrary.com/#!home" target="_blank">OUR MUSIC</a></li>
                           <li><a href="https://epicmusicla.com/why-epic/" target="_blank">WHY EPIC</a></li>
                           <li><a href="https://epicmusicla.com/contact-us/" target="_blank">CONTACT</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                     <div class="footer-sl">
                        <h4 class="title small" style="color:green;">ADDRESS</h4>
                        <ul  class="social-links">
                           <li><i class="fa fa-map-marker footer-icon"></i> <span class="footer-desc">{!! $data['footer_us_address'] !!}</span></li>
                           <li><i class="fa fa-phone footer-icon" aria-hidden="true"></i> <span class="footer-desc">{{$data['footer_phone']}}</span></li>
                           <li><i class="fa fa-envelope footer-icon" aria-hidden="true"></i> <span class="footer-desc">{{$data['footer_us_email']}}</span></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                     <div class="footer-sl">
                        <h4 class="title small"  style="color:green;">BE SOCIAL</h4>
                        <ul class="social">
                           @if($data['facebook_url'])
                           <li><a href="{{$data['facebook_url']}}" target="_blank">
                              <img width="40" height="40" src="{{ asset('public/assets/images/fb.png') }}" class="img-responsive" />
                              </a>
                           </li>
                           @endif
                           @if($data['linkedin_url'])
                           <li><a href="{{$data['linkedin_url']}}" target="_blank">
                              <img width="40" height="40" src="{{ asset('public/assets/images/in.png') }}" class="img-responsive" />
                              </a>
                           </li>
                           @endif
                           @if($data['twitter_url'])
                           <li><a href="{{$data['twitter_url']}}" target="_blank">
                              <img width="40" height="40" src="{{ asset('public/assets/images/tw.png') }}" class="img-responsive" />
                              </a>
                           </li>
                           @endif
                           @if($data['instagram_url'])
                           <li><a href="{{$data['instagram_url']}}" target="_blank">
                              <img width="40" height="40" src="{{ asset('public/assets/images/ig.png') }}" class="img-responsive" />
                              </a>
                           </li>
                           @endif
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <script>
            var yourAudio = document.getElementById('yourAudio'),
               ctrl = document.getElementById('audioControl');
            
            ctrl.onclick = function () {
            
               // Update the Button
               var pause = ctrl.innerHTML === 'SOUND';
               ctrl.innerHTML = pause ? '<del>SOUND</del>' : 'SOUND';
            
               // Update the Audio
               var method = pause ? 'pause' : 'play';
               yourAudio[method]();
            
               // Prevent Default Action
               return false;
            };
         </script>
         <script>
            $(document).ready(function(){
               if ($(window).width() >= 800){
                  $(".custom-image").each(function(){
                     var src = $(this).attr("pc-src");
                     $(this).attr("src",src);
                     alert(1)
                  });
               }
            });
         </script>
         <script src="{{ asset('public/assets/scripts/plugins.js') }}"></script>
         <script src="{{ asset('public/assets/scripts/main.js') }}"></script>
         <script src="{{ asset('public/assets/scripts/colorpicker.js') }}"></script>
         <script src="{{ asset('public/assets/scripts/vendor/bootstrap.js') }}"></script>
      </div>
      <!--<script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>-->
      @stack('js')
   </body>
</html>