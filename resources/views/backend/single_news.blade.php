@extends('layouts.app')

@section('content')
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
                                    <img class="photo-post" src="{{($single_news->photo) ? asset(config('app.f_url').'/News/'.$single_news->photo) :asset(config('app.f_url').'/default.jpg') }}" alt="">
                                </div>
                                <p class="date">
                                    <span class="day"> {{date('d', strtotime($single_news->publish_date))}}</span>
                                    <span class="month">{{date('M', strtotime($single_news->publish_date))}}</span>
                                </p>
                            </div>
                            <div class="col-sm-8">                            

                                <h3 class="title post" style="margin-top:0px">{{$single_news->title}}</h3>

                                <section class="section news-window">
                                    <div class="news-content">
                                        {!!$single_news->description!!}
                                    </div>
                                </section>
                            </div>
                        </div>
                    </article>
                            </div>
        </div>
    </div>
</div>

@endsection