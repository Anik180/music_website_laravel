<section class="section featured-artists white-bg" id="anchor02">
    <div class="container ">
            <div class="row" style="background-color: #fff; padding-bottom: 20px;">
            <div class="col-md-12">
                <div class="event-box">
                    <div class="voffset70"></div>
                    <div class="separator-icon">
                        <i class="fa fa-microphone"></i>
                    </div>
                    <div class="voffset20"></div>
                    <h2 class="title" style="color:#519a0a;">{{$title_subtitle->value }}</h2>
               
                </div>
            </div>
        </div>
        </div>
</section>

<section class="section featured-shop">
  <div id="qtMainContainer" class="qt-main-container stage qt-preloaderanimation">
    <div id="skrollr-body" class="" data-10="@class:qt-scrolled;" data-0="@class:qt-scrolledoff;">
        <div class="container">
        </div>
        <article class="qt-content qt-polydecor-page qt-polydecor-composer qt-transparent-menu post-2467 page type-page status-publish hentry" id="page2467">
            <div data-vc-parallax="1" data-vc-parallax-image="http://epicmusicla.com/others/images/metal-bg.jpg" class="vc_row wpb_row vc_row-fluid vc_custom_1471955678046 vc_row-has-fill vc_general vc_parallax vc_parallax-content-moving qt-vc-fadetopaper">
                
                <div class="container" style="margin-top: 2rem;">
                    <!-- <h1 style="color: #fff; font-weight: 800; padding: 20px; margin-bottom: 20px; font-size: 50px;" align="center">CREDIT</h1> -->
                    <div class="team-img credit-sec">
                        <div class="vc_row">
                            <div class="vc_column_container">
                              @foreach($credits as $key => $list)
                              <div class="vc_col-lg-3">
                                @if($list->youtube_link)
                                @php $youtube_url = explode("?v=", $list->youtube_link); @endphp
                                <a data-fancybox="credit" href="{{$list->youtube_link}}" data-caption="{{ $list->title }}">
                                    <img class="c-img" src="http://img.youtube.com/vi/{{$youtube_url[1]}}/mqdefault.jpg" />
                                </a>
                                @elseif($list->video)
                                <a data-fancybox="credit" data-caption="{{ $list->title }}" href="#xmVideo_{{$key}}">
                                    <img class="c-img"  src="{{ ($list->image)? asset(config('app.f_url').'/storage/app/public/uploads/Credit/'.$list->image) : asset(config('app.f_url').'/storage/app/public/uploads/2nd.png') }}">
                                </a>
                                <video width="660" height="320" controls id="xmVideo_{{$key}}" style="display:none;">
                                    <source src="{{ ($list->video)? asset(config('app.f_url').'/storage/app/public/uploads/CreditVideo/'.$list->video) : asset(config('app.f_url').'/default.jpg') }}" type="video/mp4">
                                </video>
                                @else
                                <a data-fancybox="credit" href="{{ ($list->image)? asset(config('app.f_url').'/storage/app/public/uploads/Credit/'.$list->image) : asset(config('app.f_url').'/default.jpg') }}" data-caption="{{ $list->title }}">
                                  <img class="c-img" src="{{ ($list->image)? asset(config('app.f_url').'/storage/app/public/uploads/Credit/'.$list->image) : asset(config('app.f_url').'/default.jpg') }}">
                                </a>
                                @endif
                              </div>
                              @endforeach 
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
  </div>
  
</section>