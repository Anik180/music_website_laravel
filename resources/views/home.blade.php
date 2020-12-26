@extends('layouts.app') 
@section('css')
<!-- <link rel="stylesheet" href="https://www.legacymusicproject.com/assets/frontend/css/style.css" type='text/css' media='all' /> -->
<link rel="stylesheet" href="{{asset('public/assets/css/js_composer.min.css')}}" type="text/css" media="all" />

<style>
    #swipebox-overlay {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css">
    .main-container {
        background: #fff !important;
    }
    .section {
        margin-top: 3rem;
    }
    .containers {
        margin-top: 10rem;
    }
    .team-img img {
        width: 100%;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .vc_column_container {
        padding-left: 0;
        padding-right: 0;
    }
    .vc_col-lg-3 {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
</style>

@endsection @section('content')
<!--  Home Page -->
<div id="home_slider">
        
</div>
<audio id="yourAudio" preload='none' loop>
    <source src="{{ asset('public/assets/images/1.mp3') }}" type='audio/mp3' />
</audio>
<!--@include('include.home.slider')-->
<style type="text/css">
    /*.main-container {
        background: url('others/images/epicbg.jpg') bottom no-repeat !important;
        min-height: 1524px;
    }*/
    .event-box {
        width: 97% !important;
        margin: 0 auto !important;
    }

    .expertise_title {
        color: black !important;
        font-size: 20px !important;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .expertise_title:hover {
        background-color: #ddd !important;
        color: #008000 !important;
    }
</style>
<!-- Expartise -->
<section class="section upcomming-events" id="anchor01">
    <div>
        <div id="our_exper">
        
        </div>
        <div id="all_credit">
         {{--  @include('include.home.credit') --}} 
     
        </div>
        <div id="footer">
         @include('include.home.footer')   
        </div>
        
        
    </div>
    <div class="voffset20"></div>
</section>
<style type="text/css">
    @font-face {
        font-family: "MV Boli";
        src: url("http://epicmusicla.com/assets/fonts/mvboli.eot");
        /* IE9*/
        src: url("http://epicmusicla.com/assets/fonts/mvboli.eot?#iefix") format("embedded-opentype"), /* IE6-IE8 */ url("http://epicmusicla.com/assets/fonts/mvboli.woff2") format("woff2"),
            /* chrome?firefox */ url("http://epicmusicartists.comassets/fonts/mvboli.woff") format("woff"), /* chrome?firefox */ url("http://epicmusicartists.comassets/fonts/mvboli.ttf") format("truetype"),
            /* chrome?firefox?opera?Safari, Android, iOS 4.2+*/ url("http://epicmusicartists.comassets/fonts/mvboli.svg#mvboli") format("svg");
        /* iOS 4.1- */
    }
</style>
<!-- Specialized -->
<!-- moved to our specialty page -->
<style type="text/css">
    footer {
        background: url("assets/images/footer.png") no-repeat bottom left;
        background-size: cover;
    }
    .upevent .contain a {
        color: #fff;
    }
    .upevent .contain a:hover {
        text-decoration: none;
    }
</style>
<script>
    document.getElementById("vid").play();
</script>
<script>
$(document).ready(function(){
    $.get("exper",function(data){
        $("#our_exper").html(data);
    }); 
    $.get("all_credit",function(data){
        $("#all_credit").html(data);
    });
     $.get("/home_slider",function(data){
        $("#home_slider").html(data);
    });

});
</script>

@endsection @push("js")
<script src="{{asset('public/assets/js/imagesloaded.min.js')}}"></script>

<!-- <script src="https://www.legacymusicproject.com/assets/frontend/js/masonry.min.js"></script> -->
<script src="{{asset('public/assets/js/main-min.js')}}"></script>
<script src="{{asset('public/assets/js/wp-embed.min.js')}}"></script>
<script src="{{asset('public/assets/js/js_composer_front.min.js')}}"></script>
<script src="{{asset('public/assets/js/waypoints.min.js')}}"></script>

<!-- <script src="https://www.legacymusicproject.com/assets/frontend/owl/js/owl.carousel.js"></script> -->

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endpush
