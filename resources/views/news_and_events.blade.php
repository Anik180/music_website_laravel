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
                    <h2 class="title" style="font-weight:bold;">on the news</h2>
                    <div class="voffset80"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach($news as $single_news)
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
                                <div class="voffset30"></div>
                                <h3 class="title post">{{$single_news->title}}</h3>
                                <p style="text-align:justify">{!! $single_news->short_description !!}</p>  
								<p><a href="{{url('news/'.$single_news->url)}}" class="news-btn">Read more</a></p>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection