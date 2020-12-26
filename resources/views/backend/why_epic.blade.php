@extends('layouts.app')

@section('content')
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


<!-- Expartise -->
<section id="anchor02" class="whyepic section featured-artists">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="voffset120"></div>
                <div class="separator-icon_no"></div>
                <div class="voffset20"></div>
                <h2 class="title" style="color: white;">Message from CEO</h2>
                <div class="voffset50"></div>
                <!-- <h2 class="title" style="color: #fff !important;">MESSAGE FROM CEO</h2> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="artist-page">
                    <!-- ADD NEW ARTIST FOR MAIN PICTURE HERE -->
                    <!-- Artist Body -->
                    {!! (\App\WhyEpic::where('epic_type','MESSAGE FROM CEO')->first()) ? \App\WhyEpic::where('epic_type','MESSAGE FROM CEO')->first()->description : ''!!}
                    <div class="row">
                        <div class="col-md-12 pagination text-center">
                            {{-- page link here --}}
                        </div>
                    </div>
                    <!-- NONPRONTO -->

                </div>
            </div>
        </div>
    </div>
    <div class="voffset20"></div>
</section>
<section id="anchor02" class="section featured-artists white-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="voffset70"></div>
                <h2 class="title">Our Philosophy</h2>
                <div class="voffset50"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! (\App\WhyEpic::where('epic_type','OUR PHILOSOPHY')->first()) ? \App\WhyEpic::where('epic_type','OUR PHILOSOPHY')->first()->description : ''!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="voffset100"></div>
            <p>&nbsp;</p>
            <h2 class="title">Our Process</h2>
        </div>
    </div>
    <p><img class="alignnone" src="https://epicmusicla.com/wp-content/uploads/2017/04/whyfooter.png" alt="Music Licensing Companies in usa" width="2500" height="340"></p>
    <div class="container">
        <div class="row process">
            <div class="col-md-offset-1 col-md-2">
                <h3>Learn</h3>
                {!! (\App\WhyEpic::where('our_process_type','Learn')->first()) ? \App\WhyEpic::where('our_process_type','Learn')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Connect</h3>
                {!! (\App\WhyEpic::where('our_process_type','Connect')->first()) ? \App\WhyEpic::where('our_process_type','Connect')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Collaborate</h3>
                {!! (\App\WhyEpic::where('our_process_type','Collaborate')->first()) ? \App\WhyEpic::where('our_process_type','Collaborate')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Develop</h3>
                {!! (\App\WhyEpic::where('our_process_type','Develop')->first()) ? \App\WhyEpic::where('our_process_type','Develop')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Deliver</h3>
                {!! (\App\WhyEpic::where('our_process_type','Deliver')->first()) ? \App\WhyEpic::where('our_process_type','Deliver')->first()->description: ''!!}
            </div>
           
        </div>
        <div class="voffset70"></div>
    </div>
</section>

<section id="carousel" class="testmonial">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="voffset70"></div>
                <div class="separator-icon_no"></div>
                <div class="voffset20"></div>
                <h2 class="title" style="color: white;">What our Clients are Saying….</h2>
                <div class="voffset80"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="quotes"></div>
                <div id="fade-quote-carousel" class="carousel slide" data-ride="carousel" data-interval="6000">
                    <p>
                        <br>
                        <!-- Carousel items -->
                    </p>
                    <div class="carousel-inner">
                        @foreach($client_says as $says_key => $says)
                        <div class="item {{($says_key == 0) ? 'active':''}}">
                            <blockquote>
                                <p>{{$says->desc}}</p>
                                <p>
                                    <small style="color: #ffffff; font-weight: bold;">
                                    @if($says->text_1)
                                    {{$says->text_1}}
                                    <br>
                                    @endif
                                    @if($says->text_2)
                                    {{$says->text_2}}
                                    <br>
                                    @endif
                                    @if($says->text_3)
                                    {{$says->text_3}}
                                    <br>
                                    @endif
                                    @if($says->text_4)
                                    {{$says->text_4}}
                                    @endif
                                    </small>
                                </p>
                                <p>&nbsp;</p>
                            </blockquote>
                        </div>
                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
