<section id="anchor02" class="whyepic section featured-artists">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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