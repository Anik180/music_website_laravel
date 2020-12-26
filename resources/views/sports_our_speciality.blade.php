@extends('layouts.app')
@section('css')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css">
    .main-container {
        background: #fff !important;
    }
    .section{
        margin-top: 3rem;
    }
    
    .modal.and.carousel {
        position: absolute;
    }
    .artist-page .upevents {
        text-align: center;
        color: #fff;
        float: left;
        width: 25% !important;
        height: 100% !important;
        margin: 0 0 5px 0 !important;
    }
    .upcomming-events .upevents .separator span {
        color: #ff6600;
    }
    a.btn.roundeda {
        background: #ff6600;
        color: #fff;
        border-radius: 5px;
        float: right;
    }
    .btn {
        padding: 9px 45px !important;
    }
    .track-list {
        background: #ddd;
        color: #111;
        padding: 15px;
        border-radius: 15px;
        margin-bottom: 0px;
        margin-top: 10px;
    }
    .modal-body p{
        color: #000;
        text-align: left;
    }
    .modal-body h3{
        color: #000;
        text-align: left;
        margin-left: 5px;
    }
    .modal-title {
        color: #000;
        font-size: 18px;
        font-weight: bold;
    }
    img.artist-details-img {
        border-radius: 5px !important;
    }
    p.artist-about {
        background: #eee;
        padding: 10px;
        border-radius: 10px;
        text-align: justify;
    }
    p.artist-about strong{
        display: block;
        font-size: 18px;
    }
    p.artist-about span{
        padding-left: 40px;
    }
    ul.artist-speciality {
        list-style: none;
        margin: 0;
        background: #eee;
        padding: 10px;
        border-radius: 10px;
        text-align: left;
        margin-left: 0px;
        margin-top: 15px;
        color: #111;
    }
    ul.artist-conn {

    }
    ul.artist-conn li {
        list-style: none;
        float: left;
        color: #111;
    }
    ul.artist-conn li a {
        background: #fd7320;
        margin-left: 2px;
        width: 32px;
        display: inline-block;
        padding: 3px 5px;
        color: #fff;
        font-size: 22px;
        text-align: center;
        margin-bottom: 5px;
        border-radius: 2px;
    }
    ul.artist-conn li a:hover {
        background: orange;
        text-shadow: 1px 1px 1px #000;
    }
    ul.artist-speciality li {
        padding-left: 40px;
        font-size: 16px;
    }
    audio {
        margin-left: 15px;
        height: 42px;
        width: 97%
    }
    table.music-table tr td {
        vertical-align: middle !important;
    }
    .bg-image{
        
    }
    @media (min-width:992px) {
        .modal.fade.in {
            background: rgba(0, 0, 0, 0.65);
            overflow-x: hidden;
            overflow-y: auto;
        }
    }
    @media (max-width:991px) {
        .modal.fade.in {
            background: rgba(0, 0, 0, 0.65);
            overflow: auto;
        }

        .artist-page .upevents {
            text-align: center;
            color: #fff;
            float: left;
            width: 33% !important;
            height: 100% !important;
            margin: 0 0 5px 0 !important;
        }
    }
    .modal-body {
        padding: 5px 0 !important;
    }
    .panel-body {
        font-size: 14px;
        padding: 5px !important;
        line-height: 16px;
        text-align: justify;
    }
    .panel-heading {
        padding: 1px !important;
    }
    .panel-title {
        font-size: 16px !important;
        line-height: 16px !important;
    }
    .modal-header {
        padding: 5px 15px !important;
        background: #f5f5f5;
        border-radius: 5px 5px 0 0 !important;
    }
    .modal-header .close {
        padding: 3px !important;
    }
    .panel {
        margin-bottom: 5px !important;
    }
    button.btn.np {
        background: #ff6600;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .modal-footer {
        margin-top: 5px !important;
        padding: 10px 10px 10px !important;
        border-top: 1px solid #e5e5e5 !important;
    }
    .modal.fade:not(.in).left .modal-dialog {
        -webkit-transform: translate3d(-25%, 0, 0);
        transform: translate3d(-25%, 0, 0);
    }
    .artist-page .upevents p.art-ist {
        font-size: 20px;
    }
    .artist-page .upevents .content {
        height: 300px;
    }
    .modal-body {
        padding: 5px 0 !important;
        /*max-height: 465px !important;*/
        overflow: auto;
    }
    .modal-body::-webkit-scrollbar { width: 0px; height: 1px;}
    .modal-body::-webkit-scrollbar-button {  background-color: #666; }
    .modal-body::-webkit-scrollbar-track {  background-color: #999;}
    .modal-body::-webkit-scrollbar-track-piece { background-color: #ffffff;}
    .modal-body::-webkit-scrollbar-thumb { height: 50px; background-color: #666; border-radius: 3px;}
    .modal-body::-webkit-scrollbar-corner { background-color: #999;}}
    .modal-body::-webkit-resizer { background-color: #666;}
    .modal-body{
        scrollbar-base-color: #ccc;
        scrollbar-base-color: #ccc;
        scrollbar-3dlight-color: #ccc;
        scrollbar-highlight-color: #ccc;
        scrollbar-track-color: #EBEBEB;
        scrollbar-arrow-color: black;
        scrollbar-shadow-color: #ccc;
        scrollbar-dark-shadow-color: #ccc;

    }
    .page-numbers {
        color: #eee;
        background: #86c23f;
        background: -moz-linear-gradient(top, #86c23f 0%, #269c44 100%);
        background: -webkit-linear-gradient(top, #86c23f 0%,#269c44 100%);
        background: linear-gradient(to bottom, #86c23f 0%,#269c44 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#86c23f', endColorstr='#269c44',GradientType=0 );
        padding: 5px 12px;
        border: 2px solid #101010;
    }
    .page-numbers.current, .page-numbers:hover {
        color: #269c44;
        background: #fff;
        border: 2px solid #269c44;
        text-decoration: none;
    }
    @media (max-width:767px){
        .artist-page .upevents {
            text-align: center;
            color: #fff;
            float: left;
            width: 45% !important;
            height: 100% !important;
            margin: 0 10px 5px 10px !important;
        }
    }
    @media (max-width:500px){
        .artist-page .upevents {
            text-align: center;
            color: #fff;
            float: none;
            width: 100% !important;
            height: 100% !important;
            margin: 5px 0 5px 0 !important;
        }
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script type="text/javascript">
    document.addEventListener(
        "play",
        function (e) {
            var audios = document.getElementsByTagName("audio");
            for (var i = 0, len = audios.length; i < len; i++) {
                if (audios[i] != e.target) {
                    audios[i].pause();
                    audios[i].currentTime = 0;
                }
            }
        },
        true
    );
</script>

@endsection
@section('content')

@php 
$dr_tv=DB::table('drtvs')->get();
$teamsports=DB::table('sport_teams')->first();
@endphp

<section class="section featured-shop">
    
        <div class="containers" style="max-width: 1290px;margin: 0 auto;padding: 10px;overflow: hidden;">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="voffset50"></div>
                    <div class="separator-icon">
                        <i class="fa fa-microphone" aria-hidden="true"></i>
                    </div>
                    <div class="voffset20"></div>
                    <h2 class="title" style="font-size: 25px"ss>{!! $seo->post_title !!}</h2><br>
                    <br>
                    {!! $seo->post_desc !!}
                </div>
            </div>
        <section class="section" id="anchor01" >
    <div class="container">
        <div class="row" style="background-color: #fff; padding-bottom: 20px;">
            <div class="col-md-12">
                <div class="event-box">
                    <div class="voffset70"></div>
                    <div class="separator-icon">
                        <i class="fa fa-microphone"></i>
                    </div>
                    <div class="voffset20"></div>
                    <h1 class="title" style="font-size: 25px;">{{$teamsports->title}}</h1>
                    <br />
                    {!! $teamsports->description !!}
                    <br />
                    <br />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="artist-page">
                    @foreach($sports_artist as $sports_artist_list)
                    <!-- Artist Body -->
                    <div data-toggle="modal" onclick="get_sports_artist_details({{$sports_artist_list->id}})">
                        <div class="upevents">
                            <div class="text-warning"><span></span></div>
                            <div class="contain">
                                <div
                                    class="bg-image"
                                    style="background-position: inherit; background-image: url({{($sports_artist_list->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$sports_artist_list->photo) :asset(config('app.f_url').'/default.jpg') }})"
                                ></div>
                                <div class="content">
                                    <p class="art-ist" style="margin-top:180px;">
                                        {{ $sports_artist_list->title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    @endforeach
                    <div class="row">
                        <div class="col-md-12 pagination text-center">
                            {{-- page link here --}}
                        </div>
                    </div>
                    <!-- NONPRONTO -->
                    <div class="modal sliders fade bs-example-modal-lg in left" id="trackListModal" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <!-- ENTER NAME OF ARTIST -->
                                    <h4 class="modal-title" id="myModalLabel"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-4">
                                                 <img class="artist-details-img" src="" alt="" title="" />
                                                 <img class="artist-details-img_one" src="" alt="" title="" />
                                                 <img class="artist-details-img_two" src="" alt="" title="" />
                                                 <img class="artist-details-img_three" src="" alt="" title="" />
                                                 <img class="artist-details-img_four" src="" alt="" title="" />
                                            </div>
                                   
                                            <div class="col-md-8">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <!-- ENTER MUSIC SPECIALTY -->
                                                        <h3 class="panel-title">Description</h3>
                                                    </div>
                                                    <div class="panel-body" id="music_speciality">
                                                        <!-- Music Speciality data will Append -->
                                                    </div>
                                                </div>
                                  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">DRTV Music Samples:</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table width="100%" class="music-table" align="center" id="music_data"></table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CHANGE SEARCH CRITIERIA -->
                                                <a id="here_more_link" class="hear-more btn roundeda" target="_blank">hear more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                     <div class="modal-footer">
                                      <div class="row">
                                        <div class="col-md-6 prev_btn">
                                      </div>
                                    <div class="col-md-6 next_btn">
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="voffset20"></div>
</section>
            <div class="row">
                @foreach($sports_our_speciality as $sports)
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <div class="shop-item">
                        <div class="cover" style="border:solid #000000 13px;  padding:1px;">
                            <img class="" src="{{($sports->image) ? asset(config('app.f_url').'/storage/app/public/uploads/Sports/'.$sports->image) :asset(config('app.f_url').'/default.jpg') }}" alt="">

                            <div class="rollover">
                                <img class="cover-image-2" src="https://epicmusicla.com/new/wp-content/uploads/2017/04/s8-300x300.jpg" alt="" width="300" height="300">                                     <p>
                                    <a href="{{$sports->outside_link}}" target="_blank" class="paly-icon">
                                        <img class="play-icon" src="https://epicmusicla.com/playicon.png" alt=""></a><br>
                                    <!-- <span class="sports-title">NFL</span> -->
                                </p>
                            </div>
                            <div class="separators tag"><span>{{$sports->title}}</span></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($seo->footer_title)
            <div class="row">
                <div class="col-md-12">
                    <div class="event-box">
                        <div class="voffset70"></div>
                        <div class="separator-icon">
                            <i class="fa fa-microphone"></i>
                        </div>
                        <div class="voffset20"></div>
                        <h1 class="title" style="font-size: 25px">{{ $seo->footer_title }}</h1>
                        <br>
                        {!! $seo->footer_desc !!}
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <script>
    $(document).ready(function () {
        $(".modal").on("hidden.bs.modal", function () {
            $("audio").each(function () {
                this.pause();
                this.currentTime = 0;
            });
        });
        $(".hear-more").click(function () {
            $("audio").each(function () {
                this.pause();
                this.currentTime = 0;
            });
        });
    });
</script>

<script>
    // ajax request
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    function get_sports_artist_details(id) {
        $.ajax({
            type: "GET",
            url: "/get-sports-artist-info/" + id,
            success: function (data) {
                var all_data = JSON.parse(data);
                let sports_artist_info = all_data.sports_artist_info;
                var connect_with_us = "";
                var music_data = "";
                $("#trackListModal").modal("show");
                $("#music_speciality").html(sports_artist_info.description);
                $("#myModalLabel").html(sports_artist_info.title);
                $(".artist-details-img").attr("src", "storage/app/public/uploads/SportArtist/" + sports_artist_info.photo);
                $(".artist-details-img_one").attr("src", "storage/app/public/uploads/SportArtist/" + sports_artist_info.photo_one);
                $(".artist-details-img_two").attr("src", "storage/app/public/uploads/SportArtist/" + sports_artist_info.photo_two);
                $(".artist-details-img_three").attr("src", "storage/app/public/uploads/SportArtist/" + sports_artist_info.photo_three);
                $(".artist-details-img_four").attr("src", "storage/app/public/uploads/SportArtist/" + sports_artist_info.photo_four);

                $.each(sports_artist_info.sports_artist_track_lists, function (key, val) {
                    music_data += ` <tr>
                                    <td width="15%" align="left" valign="top">${val.name}</td>
                                    <td width="85%" align="left">
                                        <audio controls controlsList="nodownload">
                                            <source src="storage/app/public/uploads/SportArtist/${val.music}" type="audio/mpeg"></source>
                                        </audio>
                                    </td>
                                </tr>`;
                });
                if(all_data.prev_data){
                    $('.prev_btn').show()
                    $('.prev_btn').empty()
                    $('.prev_btn').append(`<button type="button" class="btn np pull-left" onclick="return get_sports_artist_details(${all_data.prev_data})" data-direction='left'>Prev</button>`)
                }else{
                    $('.prev_btn').empty();
                }

                if(all_data.next_data){
                    $('.next_btn').show()
                    $('.next_btn').empty()
                    $('.next_btn').append(`<button type="button" class="btn np" onclick="return get_sports_artist_details(${all_data.next_data})" data-direction='right'>Next</button>`)
                }else{
                    $('.next_btn').empty();
                }

                $("#music_data").empty();
                $("#music_data").append(music_data);
                $("#here_more_link").attr("href", all_data.here_more_url);
            },

            error: function (data) {
                console.log(data);
            },
        });
    }
</script>
@endsection