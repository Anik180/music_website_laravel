        @if($seo->footer_title)
        <div class="row" style="background-color: #fff; padding-bottom: 20px;">
            <div class="col-md-12">
                <div class="event-box">
                    <div class="voffset70"></div>
                    <div class="separator-icon">
                        <i class="fa fa-microphone"></i>
                    </div>
                    <div class="voffset20"></div>
                    <h2 class="title" style="font-size: 25px;">{{ $seo->footer_title }}</h2>
                    <br />
                    {!! $seo->footer_desc !!}
                    <br />
                    <br />
                    <div class="text-center">
                        <a href="{{ url('/why-epic') }}" class="btn btn-sm btn-success">Read more</a>
                    </div>
                    {{-- {{ $site_setts[0]['site_name'] }} --}} {{-- {{ $site_setts }} --}}
                </div>
            </div>
        </div>
        @endif 
        @if($seo->footer_title_2)
        <div class="row" style="background-color: #fff; padding-bottom: 20px;">
            <div class="col-md-12">
                <div class="event-box">
                    <div class="voffset70"></div>
                    <div class="separator-icon">
                        <i class="fa fa-microphone"></i>
                    </div>
                    <div class="voffset20"></div>
                    <h1 class="title" style="font-size: 25px;">{{ $seo->footer_title_2 }}</h1>
                    <br />
                    {!! $seo->footer_desc_2 !!}
                    <br />
                    <br />
                </div>
            </div>
        </div>
        @endif