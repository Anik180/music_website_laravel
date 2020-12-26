    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="voffset70"></div>
                <h2 class="title">Our Philosophy</h2>
                <div class="voffset50"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! (\App\WhyEpic::where('epic_type','OUR PHILOSOPHY')->first()) ? \App\WhyEpic::where('epic_type','OUR PHILOSOPHY')->first()->description : ''!!}
            </div>
        </div>
    </div>