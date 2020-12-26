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
                <p style="text-align: center; font-size: 18px; margin-bottom: 20px;"><strong><em>Best Use of Licensed Music – </em></strong>Dan Yukhananov</p>
                <p style="text-align: center;">
                    @if($awards->video_link)
                    <iframe width="961" height="721" src="https://www.youtube.com/embed/{!!$awards->video_link!!}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @elseif($awards->video)
                    <video controls="controls" style="width: 961px; height:721px;"><br>
                        <source src="{{ asset('storage/app/public/uploads/Awards/'. $awards->video) }}"><br>
                    </video>
                    @else
                    <video controls="controls" style="width: 100%"><br>
                        <source src=""><br>
                    </video>
                    @endif
                    <br>
                </p>
                <hr>
            </div>
        </div>
        @endforeach
    </div>
</section>