@extends('layouts.app')
@section('css')
 <!-- <link rel="stylesheet" href="https://www.legacymusicproject.com/assets/frontend/css/style.css" type='text/css' media='all' /> -->
    <link rel="stylesheet" href="{{asset('public/assets/css/js_composer.min.css')}}" type='text/css' media='all' />
    
    <style>
    #swipebox-overlay {
        display: none;
    }
</style>
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
<style type="text/css">
    .main-container {
        background: #fff !important;
    }
    .section{
        margin-top: 3rem;
    }
    .containers{
        margin-top: 10rem;
    }
    .team-img .c-img {
      /*width: 100%;*/
      border-radius: 5px;
      margin-bottom: 20px;
      width: 262px;
      height: 147.375px;
    }
    .vc_column_container {
    padding-left: 0;
    padding-right: 0;
}
</style>

@endsection
@section('content')
<div id="main_credit">
    
</div>
{{-- @include('include.credits.all_credit') --}}
@endsection
@push("js")
<script src="{{asset('public/assets/js/imagesloaded.min.js')}}"></script>
    <!-- <script src="https://www.legacymusicproject.com/assets/frontend/js/masonry.min.js"></script> -->

   <script src="{{asset('public/assets/js/main-min.js')}}"></script>
   <script src="{{asset('public/assets/js/wp-embed.min.js')}}"></script>
   <script src="{{asset('public/assets/js/js_composer_front.min.js')}}"></script>
   <script src="{{asset('public/assets/js/waypoints.min.js')}}"></script>
    <!-- <script src="https://www.legacymusicproject.com/assets/frontend/owl/js/owl.carousel.js"></script> -->
    <!--<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
$(document).ready(function(){
    $.get("http://localhost/NewEpic/main_credit",function(data){
        $("#main_credit").html(data);
    }); 

});
</script>
@endpush