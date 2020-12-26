<section class="section featured-artists white-bg" id="anchor02">
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="voffset50"></div>
                <div class="separator-icon">
                    <i class="fa fa-microphone"></i>
                </div>
                <div class="voffset20"></div>
                <h1 class="title">{{ $seo->post_title }}</h1>
                {!! $seo->post_desc !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="voffset20"></div>
                <div>
                    @foreach($our_teams as $team)
                    <div class="gallery-cell col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="featured-artist">
                            <div class="image">
                                <img src="{{($team->photo) ? asset(config('app.f_url').'/storage/app/public/uploads/OurTeam/'.$team->photo) :asset(config('app.f_url').'/default.jpg') }}" alt="">
                            </div>
                            <div class="rollover">
                                <ul class="social">
                                    @if($team->facebook_url)
                                    <li><a href="{{$team->facebook_url}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    @endif
                                    @if($team->twitter_url)
                                    <li><a href="{{$team->twitter_url}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    @endif 
                                    @if($team->instragram_url)
                                    <li><a href="{{$team->instragram_url}}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                    @endif
                                    @if($team->linkedin_url)
                                    <li><a href="{{$team->linkedin_url}}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    @endif 
                                    @if($team->email_url)
                                    <li><a href="mailto: {{$team->email_url}}?Subject=From website" target="_top"><i class="fa fa-envelope"></i></a></li>
                                    @endif 
                                </ul>
                                <div class="text">
                                    <h5 class="title-artist" style="font-size:22px">{{ $team->name }}</h5>
                                    <p>
                                        {{$team->designation}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row" style="display: none;">
            <div class="col-md-12">
                <div class="voffset20"></div>
                <div>
                    <div class="row">
                        <div class="gallery-cell col-xs-12 col-sm-6 col-md-5 col-lg-5"></div>
                        <div class="gallery-cell col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="featured-artist">
                                <div class="image">
                                    <img src=" {{ asset('public/assets/images/demo/artists/td.jpg') }}" alt="">
                                </div>
                                <div class="rollover">
                                    <ul class="social">
                                        <li><a href="https://www.instagram.com/adam_n_barker/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                    <div class="text">
                                        <h5 class="title-artist" style="font-size:22px">Duke</h5>
                                        <p>Director of Cuteness</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-cell col-xs-12 col-sm-6 col-md-4 col-lg-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>