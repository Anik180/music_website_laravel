
        <div class="row" style="background-color: #fff; padding-bottom: 20px;">
            <div class="col-md-12">
                <div class="event-box">
                    <div class="voffset70"></div>
                    <div class="separator-icon">
                        <i class="fa fa-microphone"></i>
                    </div>
                    <div class="voffset20"></div>
                    <h1 class="title">{{ $seo->post_title }}</h1>
                    <br>
                    {!! $seo->post_desc !!}
                </div>
            </div>
        </div>
        <div class="row" style="background: url('public/others/images/epicbg.jpg');">
            @foreach($our_expertise as $expertise)
            <div class="col-md-4">
                <div class="upevent">
                    <div class="separator tag">
                        <span>{{$expertise->title}}</span>
                    </div>
                    <div class="contain">
                        <div class="bg-image" style="background-image: url({{asset('/storage/app/public/uploads/OurExpertise/'.$expertise->image)}})"
                          <?php if ($expertise->image_alt!='') { echo "alt='".$expertise->image_alt."'";}?>
                             
                              
                              
                           

                    >
                        



                          
                        </div>
                        <div class="content">
                            <p class="buttons" style="text-align:justify;margin-top:10px;">
                                <span style="display:block;">  {{$expertise->description}}</span>
                                <span style="position:absolute;left:5px;bottom:5px">
                                    @if($expertise->outside_link)
                                    <a href="{!! $expertise->outside_link !!}" target="_blank" class="btns">
                                        <img class="play-icon" src="https://epicmusicla.com/playicon.png" alt="">
                                    </a>
                                    @endif
                                </span>
                            </p>
                            <!-- <div class="title">HIP HOP Party Music</div> -->
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
