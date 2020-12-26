    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="voffset100"></div>
            <p>&nbsp;</p>
            <h2 class="title">Our Process</h2>
        </div>
    <p><img class="alignnone" src="{{ asset('public/assets/images/whyfooter.png') }}" alt="Music Licensing Companies in usa" width="2500" height="340"></p>
    <div class="container">
        <div class="row process">
            <div class="col-md-offset-1 col-md-2">
                <h3>Learn</h3>
                {!! (\App\WhyEpic::where('our_process_type','Learn')->first()) ? \App\WhyEpic::where('our_process_type','Learn')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Connect</h3>
                {!! (\App\WhyEpic::where('our_process_type','Connect')->first()) ? \App\WhyEpic::where('our_process_type','Connect')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Collaborate</h3>
                {!! (\App\WhyEpic::where('our_process_type','Collaborate')->first()) ? \App\WhyEpic::where('our_process_type','Collaborate')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Develop</h3>
                {!! (\App\WhyEpic::where('our_process_type','Develop')->first()) ? \App\WhyEpic::where('our_process_type','Develop')->first()->description: ''!!}
            </div>
            <div class="col-md-2">
                <h3>Deliver</h3>
                {!! (\App\WhyEpic::where('our_process_type','Deliver')->first()) ? \App\WhyEpic::where('our_process_type','Deliver')->first()->description: ''!!}
            </div>
        </div>
        <div class="voffset70"></div>
    </div>
</div>