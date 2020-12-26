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
                    <h2 class="title">on the news</h2>
                    <div class="voffset80"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @foreach($news as $single_news)
                    <article class="post-item">
                        <div class="row">
                            <div class="col-sm-4">
                                @if($single_news->video_link!= null)
                                    <video width="100%" playsinline loop autoplay muted id="vid">
                                        <source src="{{$single_news->video_link}}">
                                    </video>
                                @elseif($single_news->youtube_link!=null)
                                    <iframe width="100%" height="612" src="https://www.youtube.com/embed/{{$single_news->youtube_link}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    @elseif($single_news->video!=null)
                                    <video width="100%" playsinline loop autoplay muted id="vid">
                                        <source src="{{ asset('uploads/News/'.$single_news->video) }}" type="video/mp4">
                                    </video>
                                    @else
                                <div id="image-post">
                                    <img class="photo-post" src="{{($single_news->photo) ? asset(config('app.f_url').'/News/'.$single_news->photo) :asset(config('app.f_url').'/default.jpg') }}" alt="">
                                </div>
                                @endif
                                <p class="date">
                                    <span class="day"> {{date('d', strtotime($single_news->publish_date))}}</span>
                                    <span class="month">{{date('M', strtotime($single_news->publish_date))}}</span>
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