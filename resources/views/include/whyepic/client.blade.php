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
        
                            <div style="color: #fff !important;">
                                {!! $says->desc !!}
                            </div>
                            <div class="text-center">
                                @if($says->image)
                                <img src="{{ ($says->image)?asset(config('app.f_url').'/storage/app/public/uploads/ClientSays/'.$says->image) :asset(config('app.f_url').'/default.jpg')}}" >
                                @endif
                            </div>
                            
                        </div>
                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>