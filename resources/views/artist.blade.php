@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css">
    .main-container {
        background: #101010 !important;
    }
    .modal.and.carousel {
        position: absolute;
    }
    .artist-page .upevents {
        text-align: center;
        color: #fff;
        float: left;
        width: 25% !important;
        height: 100% !important;
        margin: 0 0 5px 0 !important;
    }
    .upcomming-events .upevents .separator span {
        color: #ff6600;
    }
    a.btn.roundeda {
        background: #ff6600;
        color: #fff;
        border-radius: 5px;
        float: right;
    }
    .btn {
        padding: 9px 45px !important;
    }
    .track-list {
        background: #ddd;
        color: #111;
        padding: 15px;
        border-radius: 15px;
        margin-bottom: 0px;
        margin-top: 10px;
    }
    .modal-body p{
        color: #000;
        text-align: left;
    }
    .modal-body h3{
        color: #000;
        text-align: left;
        margin-left: 5px;
    }
    .modal-title {
        color: #000;
        font-size: 18px;
        font-weight: bold;
    }
    img.artist-details-img {
        border-radius: 5px !important;
    }
    p.artist-about {
        background: #eee;
        padding: 10px;
        border-radius: 10px;
        text-align: justify;
    }
    p.artist-about strong{
        display: block;
        font-size: 18px;
    }
    p.artist-about span{
        padding-left: 40px;
    }
    ul.artist-speciality {
        list-style: none;
        margin: 0;
        background: #eee;
        padding: 10px;
        border-radius: 10px;
        text-align: left;
        margin-left: 0px;
        margin-top: 15px;
        color: #111;
    }
    ul.artist-conn {

    }
    ul.artist-conn li {
        list-style: none;
        float: left;
        color: #111;
    }
    ul.artist-conn li a {
        background: #fd7320;
        margin-left: 2px;
        width: 32px;
        display: inline-block;
        padding: 3px 5px;
        color: #fff;
        font-size: 22px;
        text-align: center;
        margin-bottom: 5px;
        border-radius: 2px;
    }
    ul.artist-conn li a:hover {
        background: orange;
        text-shadow: 1px 1px 1px #000;
    }
    ul.artist-speciality li {
        padding-left: 40px;
        font-size: 16px;
    }
    audio {
        margin-left: 15px;
        height: 42px;
        width: 97%
    }
    table.music-table tr td {
        vertical-align: middle !important;
    }
    
    .modal-body {
        padding: 5px 0 !important;
    }
    .panel-body {
        font-size: 14px;
        padding: 5px !important;
        line-height: 16px;
        text-align: justify;
    }
    .panel-heading {
        padding: 1px !important;
    }
    .panel-title {
        font-size: 16px !important;
        line-height: 16px !important;
    }
    .modal-header {
        padding: 5px 15px !important;
        background: #f5f5f5;
        border-radius: 5px 5px 0 0 !important;
    }
    .modal-header .close {
        padding: 3px !important;
    }
    .panel {
        margin-bottom: 5px !important;
    }
    button.btn.np {
        background: #ff6600;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .modal-footer {
        margin-top: 5px !important;
        padding: 10px 10px 10px !important;
        border-top: 1px solid #e5e5e5 !important;
    }
   
    .artist-page .upevents p.art-ist {
        font-size: 12px;
    }
    .artist-page .upevents .content {
        height: 300px;
    }
    .modal-body {
        padding: 5px 0 !important;
        /*max-height: 465px !important;*/
        overflow: auto;
    }
    .modal-body::-webkit-scrollbar { width: 0px; height: 1px;}
    .modal-body::-webkit-scrollbar-button {  background-color: #666; }
    .modal-body::-webkit-scrollbar-track {  background-color: #999;}
    .modal-body::-webkit-scrollbar-track-piece { background-color: #ffffff;}
    .modal-body::-webkit-scrollbar-thumb { height: 50px; background-color: #666; border-radius: 3px;}
    .modal-body::-webkit-scrollbar-corner { background-color: #999;}}
    .modal-body::-webkit-resizer { background-color: #666;}
    .modal-body{
        scrollbar-base-color: #ccc;
        scrollbar-base-color: #ccc;
        scrollbar-3dlight-color: #ccc;
        scrollbar-highlight-color: #ccc;
        scrollbar-track-color: #EBEBEB;
        scrollbar-arrow-color: black;
        scrollbar-shadow-color: #ccc;
        scrollbar-dark-shadow-color: #ccc;

    }
    .page-numbers {
        color: #eee;
        background: #86c23f;
        background: -moz-linear-gradient(top, #86c23f 0%, #269c44 100%);
        background: -webkit-linear-gradient(top, #86c23f 0%,#269c44 100%);
        background: linear-gradient(to bottom, #86c23f 0%,#269c44 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#86c23f', endColorstr='#269c44',GradientType=0 );
        padding: 5px 12px;
        border: 2px solid #101010;
    }
    .page-numbers.current, .page-numbers:hover {
        color: #269c44;
        background: #fff;
        border: 2px solid #269c44;
        text-decoration: none;
    }
    @media (max-width:767px){
        .artist-page .upevents {
            text-align: center;
            color: #fff;
            float: left;
            width: 45% !important;
            height: 100% !important;
            margin: 0 10px 5px 10px !important;
        }
    }
    @media (max-width:500px){
        .artist-page .upevents {
            text-align: center;
            color: #fff;
            float: none;
            width: 100% !important;
            height: 100% !important;
            margin: 5px 0 5px 0 !important;
        }
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script type="text/javascript">
    document.addEventListener('play', function(e){
        var audios = document.getElementsByTagName('audio');
        for(var i = 0, len = audios.length; i < len;i++){
            if(audios[i] != e.target){
                audios[i].pause();
                audios[i].currentTime = 0;
            }
        }
    }, true);
</script>

<!-- Expartise -->

<div id="epic_art">
   
</div>
{{-- @include('include.epicartist.epic_artist') --}}
<script>
$(document).ready(function () {
    $('.modal').on('hidden.bs.modal', function () {
        $('audio').each(function(){
            this.pause() ;
            this.currentTime = 0;
        });

    });
    $('.hear-more').click(function () {
        $('audio').each(function(){
            this.pause() ;
            this.currentTime = 0;
        });
    });
});
</script>

<script>
    // ajax request
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function get_details(id){
        $('#trackListModal').modal('hide')
        $.ajax({
            type:'GET',
            url:'/get-epic-artists-info/' + id,
            success:function(data){
                var all_data = JSON.parse(data);
                let epic_artists_info = all_data.epic_artists_info;
                var connect_with_us = '';
                var music_data = '';
                $('#trackListModal').modal('show')
                $('#about_artists').html(epic_artists_info.about)
                $('#music_speciality').html(epic_artists_info.music_speciality)
                $('#myModalLabel').html(epic_artists_info.name)
                $('.artist-details-img').attr('src','storage/app/public/uploads/epicArtists/'+epic_artists_info.photo)
                $(".artist-details-img_one").attr("src", "storage/app/public/uploads/epicArtists/" + epic_artists_info.photo_one);
                $(".artist-details-img_two").attr("src", "storage/app/public/uploads/epicArtists/" + epic_artists_info.photo_two);
                $(".artist-details-img_three").attr("src", "storage/app/public/uploads/epicArtists/" + epic_artists_info.photo_three);
                $(".artist-details-img_four").attr("src", "storage/app/public/uploads/epicArtists/" + epic_artists_info.photo_four);

                if(epic_artists_info.facebook){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Facebook" href="${epic_artists_info.facebook}"><i class="fa fa-facebook"></i></a></a></li>`;
                }
                if(epic_artists_info.instragram){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Instagram" href="${epic_artists_info.instragram}"><i class="fa fa-instagram"></i></a></li>`;
                }
                if(epic_artists_info.twitter){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Twitter" href="${epic_artists_info.twitter}"><i class="fa fa-twitter"></i></a></li>`;
                }
                if(epic_artists_info.youtube){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Youtube" href="${epic_artists_info.youtube}"><i class="fa fa-youtube"></i></a></li>`;
                }
                if(epic_artists_info.email){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Mailing List" href="${epic_artists_info.email}"><i class="fa fa-envelope-o"></i></a></li>`;
                }if(epic_artists_info.linkedin){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="linkedin" href="${epic_artists_info.linkedin}"><i class="fa fa-linkedin"></i></a></li>`;
                }
                if(epic_artists_info.itunes){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="iTunes" href="${epic_artists_info.itunes}"><i class="fa fa-info"></i></a></li>`;
                }
                if(epic_artists_info.bandcamp){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Bandcamp" href="${epic_artists_info.bandcamp}"><i class="fa fa-headphones"></i></a></li>`;
                }
                if(epic_artists_info.disk_download){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Disc download" href="${epic_artists_info.disk_download}"><i class="fa fa-dot-circle-o"></i></a></li>`;
                }
                if(epic_artists_info.spotify){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Spotify" href="${epic_artists_info.spotify}"><i class="fa fa-spotify"></i></a></li>`;
                }
                if(epic_artists_info.apple_music){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Apple Music" href="${epic_artists_info.apple_music}"><i class="fa fa-apple"></i></a></li>`;
                }
                if(epic_artists_info.sound_cloud){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="Sound Cloud" href="${epic_artists_info.sound_cloud}"><i class="fa fa-soundcloud"></i></a></li>`;
                }
                if(epic_artists_info.website){
                    connect_with_us += `<li><a target="_blank" data-toggle="tooltip" data-placement="top" title="browser" href="${epic_artists_info.website}"><i class="fa fa-globe"></i></a></li>`;
                }

                $.each(epic_artists_info.track_lists, function(key, val) {
                    music_data+=` <tr>
                                        <td width="15%" align="left" valign="top">${val.name}</td>
                                            <td width="85%" align="left">
                                                <audio controls controlsList="nodownload">
                                                    <source src="storage/app/public/uploads/music/${val.music}" type="audio/mpeg"></source>
                                                </audio>
                                            </td>
                                  </tr>`;

                });
                if(all_data.prev_data){
                    $('.prev_btn').show()
                    $('.prev_btn').empty()
                    $('.prev_btn').append(`<button type="button" class="btn np pull-left" onclick="return get_details(${all_data.prev_data})" data-direction='left'>Prev</button>`)
                }else{
                    $('.prev_btn').empty();
                }

                if(all_data.next_data){
                    $('.next_btn').show()
                    $('.next_btn').empty()
                    $('.next_btn').append(`<button type="button" class="btn np" onclick="return get_details(${all_data.next_data})" data-direction='right'>Next</button>`)
                }else{
                    $('.next_btn').empty();
                }

                $('#music_data').empty();  
                $('#music_data').append(music_data);  
                $('#connect_with_us').empty();  
                $('#connect_with_us').append(connect_with_us);  
                $('#here_more_link').attr('href',epic_artists_info.here_more_url);
            },

            error:function(data){ 
                console.log(data)
            }

        });
    }
    
</script>
<script>
$(document).ready(function(){
    $.get("epic_art",function(data){
        $("#epic_art").html(data);
    }); 

});
</script>
@endsection