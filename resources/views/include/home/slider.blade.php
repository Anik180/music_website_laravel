@foreach($sliders as $slider)
    @if($slider->video_link!= null)
        <video width="100%" playsinline loop autoplay muted id="vid">
            <source src="{{$slider->video_link}}">
        </video>
    @elseif($slider->youtube_video_link!=null)
        <iframe width="100%" height="612" src="https://www.youtube.com/embed/{{$slider->youtube_video_link}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
    <video width="100%" playsinline loop autoplay muted id="vid">
        <source src="{{ asset('storage/app/public/uploads/slider/'. $slider->video) }}" type="video/mp4">
    </video>
    @endif
@endforeach
