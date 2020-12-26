@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css">
   
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

<section id="anchor02" class="section featured-artists white-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="separator-icon_no"></div>
                <div class="voffset20"></div>
                <div class="voffset50"></div>
                <!-- <h2 class="title" style="color: #fff !important;">MESSAGE FROM CEO</h2> -->
            </div>
        </div>

        @foreach($music_awards as $key => $awards)
        <div class="row">
            <div class="col-md-10 col-md-offset-2" style="float: none; margin: auto;">
                <div class="voffset70"></div>
                <h3 style="text-align: center; color: #519a0a; font-size: 20px;"><strong>{{$awards->title}}</strong></h3>
                
                <p style="text-align: center; font-size: 18px;">{{$awards->sub_title}}</p>
                <p style="text-align: center; padding: 10px 20px; font-size: 18px;">{{$awards->description}}</p>
                <p style="text-align: center; font-size: 18px; margin-bottom: 20px;"><strong><em>Best Use of Licensed Music – </em></strong>{{$awards->best_music}}</p>
                <p style="text-align: center;">
                    @if($awards->video_link==!NULL)
                    @php $link = explode("?v=", $awards->video_link); @endphp
                    <iframe width="961" height="721" src="https://www.youtube.com/embed/{{$link[1]}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @elseif($awards->video)
                    <video controls="controls" style="width: 961px; height:721px;"><br>
                        <source src="{{ asset('storage/app/public/uploads/Awards/'. $awards->video) }}"><br>
                    </video>
                {{--     @else
                    <video controls="controls" style="width: 100%"><br>
                        <source src=""><br>
                    </video> --}}
                    @endif
                    <br>
                </p>
                <hr>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!--<div id="all_awards">-->
    
<!--</div>-->
{{-- @include('include.award.all_award') --}}
// <script>
// $(document).ready(function(){
//     $.get("http://music.dainikbagmara.com.bd/all_awards/2017-award-winners",function(data){
//         $("#all_awards").html(data);
//     }); 

// });
// </script>
@endsection