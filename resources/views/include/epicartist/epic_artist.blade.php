<section class="section" id="anchor01">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="voffset70"></div>
                <div class="voffset70"></div>
                <div class="voffset120"></div>
                <div class="separator-icon">
                    <i class="fa fa-microphone"></i>
                </div>
                <div class="voffset20"></div>
                <h1 class="title">{{ $seo->post_title }}</h1>
                {{-- <div class="voffset50"></div> --}}
                {!! $seo->post_desc !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="artist-page">
                    @foreach($epic_artists as $artists)
                    <!-- ADD NEW ARTIST FOR MAIN PICTURE HERE -->
                    <!-- Artist Body -->
                    <div data-toggle="modal" onclick="get_details({{ $artists->id }})">
                        <div class="upevents">
                            <div class="separator tag"><span>{{ $artists->name }}</span></div>
                            <div class="contain" >
                                <div class="bg-image" style="background-image: url({{asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$artists->photo)}})"></div>
                                <div class="content">
                                    <p class="art-ist">
                                        {{ $artists->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    @endforeach
                    <div class="row">
                        <div class="col-md-12 pagination text-center">
                            {{-- page link here --}}
                        </div>
                    </div>
                    <!-- NONPRONTO -->
                    

                    <div class="modal sliders bs-example-modal-lg in left" id="trackListModal" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <!-- ENTER NAME OF ARTIST -->
                                    <h4 class="modal-title" id="myModalLabel"></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-4">
                                                 <img class="artist-details-img" src="" alt="" title="">
                                                 <img class="artist-details-img_one" src="" alt="" title="" />
                                                 <img class="artist-details-img_two" src="" alt="" title="" />
                                                 <img class="artist-details-img_three" src="" alt="" title="" />
                                                 <img class="artist-details-img_four" src="" alt="" title="" />
                                            </div>
                                            <div class="col-md-8">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">About artist</h3>
                                                    </div>
                                                    <div class="panel-body" id="about_artists">
                                                        <!-- Abput Artists data will Append -->
                                                    </div>
                                                </div>  
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <!-- ENTER MUSIC SPECIALTY -->
                                                        <h3 class="panel-title">Music specialty</h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <p id="music_speciality"></p>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Connect with us</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul class="artist-conn" id="connect_with_us"></ul>
                                                        </div>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Track list</h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <table width="100%" class="music-table" align="center" id="music_data">
                                                                
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- CHANGE SEARCH CRITIERIA -->
                                                <a id="here_more_link" class="hear-more btn roundeda" target="_blank">hear more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-6 prev_btn">
                                        </div>
                                        <div class="col-md-6 next_btn">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="voffset20"></div>
</section>