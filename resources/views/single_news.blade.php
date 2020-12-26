@extends('layouts.app')
@section('meta')
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
@if($single_news->meta_titles==NULL)
<meta property="og:title" content="{{$single_news->title}}" />
@else
<meta property="og:title" content="{{$single_news->meta_titles}}" />
@endif
@if($single_news->meta_description==NULL)
<meta property="og:description" content="{!! substr($single_news->description, 0,  255) !!}" />


@else
<meta property="og:description" content="{!! $single_news->meta_description !!}" />
@endif
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{($single_news->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$single_news->photo) :asset(config('app.f_url').'/default.jpg') }}" />
<meta property="og:image:secure_url" content="{{($single_news->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$single_news->photo) :asset(config('app.f_url').'/default.jpg') }}" />
<meta property="og:image:width" content="660" />
<meta property="og:image:height" content="338" />
<meta name="twitter:card" content="summary" />
 
<meta name="twitter:url" content="{{ url()->current() }}" />

@if($single_news->meta_description==NULL)
<meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(htmlspecialchars($single_news->description), 255, '...') }}">
@else
<meta name="twitter:description" content="{!! $single_news->meta_description !!}">
@endif
@if($single_news->meta_titles==NULL)
<meta name="twitter:title" content="{{$single_news->title}}">
@else
<meta name="twitter:title" content="{{$single_news->meta_titles}}">
@endif
 
<meta name="twitter:site" content="@epicmusicla" />

<meta name="twitter:image" content="{{($single_news->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$single_news->photo) :asset(config('app.f_url').'/default.jpg') }}">
<link rel="canonical" href="{{ url()->current() }}">
{{-- 
<meta name="twitter:image:alt" content="paribahanhisahb.com" />
--}}
<meta name="twitter:creator" content="@epicmusicla">

@if($single_news->title_two==NULL)
<title>{{$single_news->title}}</title>
@else
<title>{{$single_news->title_two}}</title>
@endif

@endsection
@section('content')


<!-- Google font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,400i,600,600i,700,700i,900">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i">
<!-- carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<style type="text/css">
   .blog_section {
   padding-top: 5rem;
   padding-bottom: 3rem;
   }
   .blog_section .blog_content .blog_item {
   margin-bottom: 30px;
   box-shadow: 0 0 11px 0 rgba(6, 22, 58, 0.14);
   position: relative;
   border-radius: 2px;
   overflow: hidden;
   }
   .blog_section .blog_content .blog_item:hover .blog_image img {
   transform: scale(1.1);
   }
   .blog_section .blog_content .blog_item .blog_image {
   overflow: hidden;
   padding: 0;
   }
   .blog_section .blog_content .blog_item .blog_image img {
   width: 100%;
   transition: transform 0.5s ease-in-out;
   }
   .blog_section .blog_content .blog_item .blog_image span i {
   position: absolute;
   z-index: 2;
   color: #fff;
   font-size: 18px;
   width: 38px;
   height: 45px;
   padding-top: 7px;
   text-align: center;
   right: 20px;
   top: 0;
   -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 79%, 0 100%);
   clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 79%, 0 100%);
   background-color: #ff5e14;
   }
   .blog_section .blog_content .blog_item .blog_details {
   padding: 25px 20px 30px 20px;
   }
   .blog_section .blog_content .blog_item .blog_details .blog_title h5 a {
   color: #020d26;
   margin-top: 0;
   margin-bottom: 10px;
   font-size: 25px;
   line-height: 32px;
   font-weight: 400;
   transition: all 0.3s;
   text-decoration: none;
   }
   .blog_section .blog_content .blog_item .blog_details .blog_title h5 a:hover {
   color: #ff5e14;
   }
   .blog_section .blog_content .blog_item .blog_details ul {
   padding: 0 3px 10px 0;
   margin: 0;
   }
   .blog_section .blog_content .blog_item .blog_details ul li {
   display: inline-block;
   padding-right: 15px;
   position: relative;
   color: #7f7f7f;
   }
   .blog_section .blog_content .blog_item .blog_details ul li i {
   padding-right: 7px;
   }
   .blog_section .blog_content .blog_item .blog_details p {
   border-top: 1px solid #e5e5e5;
   margin-top: 4px;
   padding: 20px 0 4px;
   }
   .blog_section .blog_content .blog_item .blog_details a {
   font-size: 16px;
   display: inline-block;
   color: #ff5e14;
   font-weight: 600;
   text-decoration: none;
   transition: all 0.3s;
   }
   .blog_section .blog_content .blog_item .blog_details a:hover {
   color: #020d26;
   }
   .blog_section .blog_content .blog_item .blog_details a i {
   vertical-align: middle;
   font-size: 20px;
   }
   .blog_section .blog_content .owl-nav {
   display: block;
   }
   .blog_section .blog_content .owl-nav .owl-prev {
   position: absolute;
   left: -27px;
   top: 33%;
   border: 5px solid #fff;
   text-align: center;
   z-index: 5;
   width: 40px;
   height: 40px;
   border-radius: 50%;
   outline: 0;
   background: #ff5e14;
   transition: all 0.3s;
   color: #fff;
   }
   .blog_section .blog_content .owl-nav .owl-prev span {
   font-size: 25px;
   margin-top: -6px;
   display: inline-block;
   }
   .blog_section .blog_content .owl-nav .owl-prev:hover {
   background: #fff;
   border-color: #ff5e14;
   color: #ff5e14;
   }
   .blog_section .blog_content .owl-nav .owl-next {
   position: absolute;
   right: -27px;
   top: 33%;
   border: 5px solid #fff;
   text-align: center;
   z-index: 5;
   width: 40px;
   height: 40px;
   border-radius: 50%;
   outline: 0;
   background: #ff5e14;
   color: #fff;
   transition: all 0.3s;
   }
   .blog_section .blog_content .owl-nav .owl-next span {
   font-size: 25px;
   margin-top: -6px;
   display: inline-block;
   }
   .blog_section .blog_content .owl-nav .owl-next:hover {
   background: #fff;
   border-color: #ff5e14;
   color: #ff5e14;
   }
   @media only screen and (max-width: 577px) {
   .blog_section .owl-nav .owl-prev {
   left: -17px !important;
   }
   .blog_section .owl-nav .owl-next {
   right: -17px !important;
   }
   }
</style>
<div class="section blog list-posts  white-bg" id="anchor07">
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="voffset120"></div>
            <div class="separator-icon">
               <i class="fa fa-microphone" aria-hidden="true"></i>
            </div>
            <div class="voffset30"></div>
            <p class="pretitle">News Details</p>
            <div class="voffset80"></div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <article class="post-item">
               <div class="row">
                  <div class="col-sm-4">
                     <div id="image-post">
                        <img class="photo-post" src="{{($single_news->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$single_news->photo) :asset(config('app.f_url').'/default.jpg') }}" alt="">
                     </div>
                     <p class="date">
                        <span class="day"> {{date('d', strtotime($single_news->publish_date))}}</span>
                        <span class="month">{{date('M', strtotime($single_news->publish_date))}}</span>
                        <span>{{date('Y', strtotime($single_news->publish_date))}}</span>
                     </p>
                  </div>
                  <div class="col-sm-8">
                     <h1 class="title post" style="margin-top:0px">{{$single_news->title}}</h1>
                     <section class="section news-window">
                        <div class="news-content">
                           {!!$single_news->description!!}
                        </div>
                        <br>
                        @if($single_news->youtube_link!=null)
                        @php $yt_video = explode("?v=", $single_news->youtube_link); 
                        @endphp
                        @if(isset($yt_video[1]))
                        <iframe width="100%" height="300" src="https://www.youtube.com/embed/{{$yt_video[1]}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @endif
                        @endif  
                        <br> 
                        @if($single_news->video!=null)
                        <video width="100%" height="300" controls>
                           <source src="{{ asset(config('app.f_url').'/storage/app/public/uploads/News/'.$single_news->video) }}" type="video/mp4">
                        </video>
                        @endif
                     </section>
                  </div>
               </div>
            </article>
         </div>
      </div>
   </div>
   @php
   $more=DB::table('news')->where('status',1)->orderBy('id','DESC')->inRandomOrder()->get();
   @endphp
   <section class="blog_section">
      <div class="container">
         <div class="blog_content">
            <div class="owl-carousel owl-theme">
               @foreach($more as $row)
               <div class="blog_item">
                  <div class="blog_image">
                     <img class="photo-post" style="max-height: 374px; max-width: 399px;" src="{{($row->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$row->photo) :asset(config('app.f_url').'/default.jpg') }}" alt="images not found">
                     <span><i class="icon ion-md-create"></i></span>
                  </div>
                  <div class="blog_details">
                     <div class="blog_title">
                        <h5><a href="{{url('news/'.$row->url)}}">{{ \Illuminate\Support\Str::limit($row->title, 20, '...') }}</a></h5>
                     </div>
                     <ul>
                        <li><i class="icon ion-md-calendar"></i>{{$row->publish_date}}</li>
                     </ul>
                     <a href="{{url('news/'.$row->url)}}">Read More<i class="icofont-long-arrow-right"></i></a>
                  </div>
               </div>
               @endforeach            
            </div>
         </div>
      </div>
   </section>
</div>
<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<!-- carousel -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script type="text/javascript">
   $('.owl-carousel').owlCarousel({
      loop:true,
      margin:10,
      dots:false,
      nav:true,
      autoplay:true,   
      smartSpeed: 3000, 
      autoplayTimeout:7000,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:2
          },
          1000:{
              items:3
          }
      }
   })
</script>
@endsection