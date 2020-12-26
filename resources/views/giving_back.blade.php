@extends('layouts.app')
@section('content')
<section id="anchor02" class="section featured-artists white-bg" style="margin-top: 4rem;">
    <div class="container">
        @foreach($lists as $key => $list)
       <!--  @if($key != 0)
        <div class="separator-icon">
            <i class="fa fa-microphone" aria-hidden="true"></i>
        </div>
        @endif -->
        <div class="separator-icon" style="margin-top: 2rem;">
            <i class="fa fa-microphone" aria-hidden="true"></i>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="voffset20"></div>
                <h2 class="text-center" style="color: #519a0a; font-size: 22px; padding: 30px 0px 40px 0px;">
                    {{$list->title}}
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p style="text-align: justify;">
                    <img class="alignnone" style="float: left; padding: 12px 17px 7px 0px; width: 39%;" src="{{asset(config('app.f_url').'/storage/app/public/uploads/Education/'.$list->image)}}" alt="{{$list->title}}" width="500" height="375">
                </p>
                {!! $list->desc !!}
            </div>
        </div>
        <div class="voffset50"></div>
        @endforeach
        <div class="separator-icon">
            <i class="fa fa-microphone" aria-hidden="true"></i>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! \App\SiteSetting::select('value')->where('key','interested_in_working')->first()->value !!}
                <div class="row" style="margin-bottom: 70px;">
                    @foreach($interested_in_working as $int_work)
                    <div class="col-md-4 text-center">
                        <img class="fullImage" style="float: left; padding: 17px; margin: 0 auto;" src="{{ ($int_work->image)? asset(config('app.f_url').'/storage/app/public/uploads/interestedWorking/'.$int_work->image) : asset(config('app.f_url').'/default.jpg') }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection