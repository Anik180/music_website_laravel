@extends('layouts.app')

@section('content')
@php
$data = [];
$siteSetting = \App\SiteSetting::all();
foreach($siteSetting as $site_data)
$data[$site_data->key] = $site_data->value;

@endphp
<section id="anchor02" class="section featured-artists white-bg" style="margin-top:5rem; ">
    <div class="container">
        <h1 style="opacity:{{$data['opacity_one']}};">{{$data['heading_one']}}</h1>
        @foreach ($lists as $list)
        <div class="separator-icon" style="margin-top: 2rem;">
            <i class="fa fa-microphone" aria-hidden="true"></i>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(isset($list->sub_title))
                <h4 class="title2 " style="color: #519a0a; padding: 0px 0px 20px 0px; text-transform: none;">{{ $list->sub_title }}<br>
                @endif
                <p style="text-align: justify; color: black; clear: both;">{!! $list->desc !!}</p>
                <h1 style="color: white;">Custom Music in usa|Custom Music</h1>
            </div>
        </div>
        @endforeach
    </div>
</section>
<style> .social-links {
    margin: 0;
    padding: 0;
}
ul.img-gallery li a img {
    width: auto !important;
    height: auto !important;
    padding: 0 !important;
}
.social-links li,
.social-nav li {
    display: block;
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 10px 0;
    text-transform: initial;
}
.social-links li i {
    margin-right: 10px;
    color: #519a0a;
}
.social,
.social-nav {
    margin: 0;
    padding: 0;
}
.social li {
    display: inline-block;
}
.social li a img {
    height: 40px;
    width: 40px;
    cursor: pointer;
}
.social-nav li.active {
    text-decoration: underline;
}
.social-nav li a {
    color: #fff;
    margin: 0 0 10px 0;
}
ul.img-gallery.footer-all li a img {
    height: 70px;
    transition: 0.5s;
}
ul.img-gallery.footer-all li a img:hover {
    transform: scale(1.5);
}
@media only screen and (max-width: 767px) {
    .footer-sl {
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }
    h4.title.small {
        text-align: center !important;
        font-size: 25px !important;
    }
}
.footer-news a {
    display: inline-flex;
    align-items: center;
    margin: 0 0 10px 0;
}
.footer-news a h3 {
    margin-left: 5px;
    color: #fff;
}
</style>
@endsection