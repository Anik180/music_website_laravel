@extends('backend.layout') @section('css')
<style type="text/css">
    .modal-lg,
    .modal-xl {
        max-width: 90% !important;
    }
</style>
@endsection @section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}} List</h3>
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal" style="margin-right: 5px;"><i class="fas fa-plus-circle"></i>Add New</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                      <th width="15%">Sort</th>
                      <th width="10%">Artist Name</th>
                      <th width="5%">Speciality</th>
                      <th width="10%">Images</th>
                      <th width="5%">Images One</th>
                      <th width="5%">Images Two</th>
                      <th width="5%">Images Three</th>
                      <th width="5%">Images Four</th>
                      <th width="10%">Status</th>
                      <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($epick_artists as $key=>$list)
                                <tr>
                                    <td>
                                        <form action="{{ url('admin/epic-artist-sort') }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" name="id" value="{{ $list->id }}" required />
                                                <input type="number" class="form-control" name="sort" value="{{ $list->sort }}" required />
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{($list->name)}}</td>
                                    <td>{{($list->music_speciality)}}</td>
                                    <td>
                                        <img src="{{ ($list->photo)?asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo) }}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                     @if($list->photo_one==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                     
                                     @else
                                    <td>
                                        <img src="{{ ($list->photo_one)?asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_one) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_one) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                         <button class="btn btn-info btn-sm" onclick="imageOneUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                 
                                    </td>
                                    @endif
                                  
                                     @if($list->photo_two==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                    @else
                                    <td>
                                        <img src="{{ ($list->photo_two)?asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_two) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_two) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                         <button class="btn btn-info btn-sm" onclick="imageTwoUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    @endif
                                     @if($list->photo_three ==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                    @else
                                         <td>
                                        <img src="{{ ($list->photo_three)?asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_three) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_three) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageThreeUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    @endif
                                    @if($list->photo_four==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                    @else   
                                      <td>
                                        <img src="{{ ($list->photo_four)?asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_four) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/epicArtists/'.$list->photo_four) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageFourUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    @endif
                                    <!-- <td>{{($list->photo) ? asset('uploads/epicArtists/'.$list->photo) :'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/1200px-Circle-icons-profile.svg.png'}}</td> -->
                                    <td>
                                        @if($list->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button>
                                        @elseif($list->status == 2)
                                        <button class="btn btn-danger btn-sm">In Active</button>
                                        @else
                                        <button class="btn btn-secondary btn-sm">Not Define</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('admin/epic-artists/track-list/'.$list->id)}}" title="Track List" class="btn btn-warning btn-sm"><i class="fa fa-music"></i> Track</a>
                                        <button class="btn btn-info waves-effect btn-md" onclick="return GetEpicArtistsData(<?php echo $list->id; ?>)"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{route('epicArtists.destroy',$list->id)}}" method="post" style="display: none;">
                                            @method('delete') @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                      <th width="15%">Sort</th>
                      <th width="10%">Artist Name</th>
                      <th width="5%">Speciality</th>
                      <th width="10%">Images</th>
                      <th width="5%">Images One</th>
                      <th width="5%">Images Two</th>
                      <th width="5%">Images Three</th>
                      <th width="5%">Images Four</th>
                      <th width="10%">Status</th>
                      <th width="20%">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{$title}} Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" accept="{{url('admin/epicArtists')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" required="" placeholder="Enter Name" />
                            </div>
                            <div class="form-group">
                                <label>Music Speciality<span class="required">*</span></label>
                                <input type="text" class="form-control" name="music_speciality" required="" placeholder="Enter Music Speciality" />
                            </div>
                            <div class="form-group">
                                <label>Picture Description<span class="required">*</span></label>
                                <textarea class="form-control" name="description" required placeholder="Enter Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>About Artists<span class="required">*</span></label>
                                <textarea class="form-control" name="about" required placeholder="Enter About Artists"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status<span class="required">*</span></label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" class="form-control" name="image" />
                            </div>
                               <div class="form-group">
                                <label>Photo One</label>
                                <input type="file" class="form-control" name="photo_one" />
                            </div>
                        </div>
                        <div class="col-md-7">
                               <div class="row">
                                <div class="col">
                                    <label>Photo Two</label>
                                    <input type="file" name="photo_two" class="form-control" />
                                </div>
                                <div class="col">
                                    <label>Photo Three</label>
                                    <input type="file" name="photo_three" class="form-control"  />
                                </div>
                            </div>
                             <div class="form-group">
                                <label>Photo Four</label>
                                <input type="file" class="form-control" name="photo_four" />
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Facebook Url</label>
                                    <input type="text" name="facebook" class="form-control" placeholder="Facebook Url" />
                                </div>
                                <div class="col">
                                    <label>Twitter Url</label>
                                    <input type="text" name="twitter" class="form-control" placeholder="Twitter Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Instragram Url</label>
                                    <input type="text" name="instragram" class="form-control" placeholder="Instragram Url" />
                                </div>
                                <div class="col">
                                    <label>Youtube Url</label>
                                    <input type="text" name="youtube" class="form-control" placeholder="Youtube Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>E-mail Url</label>
                                    <input type="text" name="email" class="form-control" placeholder="E-mail Url" />
                                </div>

                                <div class="col">
                                    <label>Linkedin Url</label>
                                    <input type="text" name="linkedin" class="form-control" placeholder="Linkedin Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>I-Tunes Url</label>
                                    <input type="text" name="itunes" class="form-control" placeholder="I-Tunes Url" />
                                </div>
                                <div class="col">
                                    <label>Bandcamp Url</label>
                                    <input type="text" name="bandcamp" class="form-control" placeholder="Bandcamp Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Disk Download Url</label>
                                    <input type="text" name="dsik_download" class="form-control" placeholder="Disk Download Url" />
                                </div>
                                <div class="col">
                                    <label>Spotify Url</label>
                                    <input type="text" name="spotify" class="form-control" placeholder="Spotify Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Apple Music Url</label>
                                    <input type="text" name="apple_music" class="form-control" placeholder="Apple Music Url" />
                                </div>
                                <div class="col">
                                    <label>Sound Cloud Url</label>
                                    <input type="text" name="sound_cloud" class="form-control" placeholder="Sound Cloud Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Personal Website Url</label>
                                    <input type="text" name="website" class="form-control" placeholder="Personl Website Url" />
                                </div>
                                <div class="col">
                                    <label>Here More Url</label>
                                    <input type="text" name="here_more_url" class="form-control" placeholder="Here More Url" />
                                </div>
                            </div>
                            <div class="modal-footer" style="float: right;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Update {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{url('admin/epicArtists/update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="name" class="form-control" name="name" required="" />
                            </div>
                            <div class="form-group">
                                <label>Music Speciality</label>
                                <input type="text" id="music_speciality" class="form-control" name="music_speciality" required="" />
                            </div>
                            <div class="form-group">
                                <label>Picture Description</label>
                                <textarea class="form-control" id="description" name="description" required placeholder="Enter Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>About Artists</label>
                                <textarea id="about" class="form-control" name="about" required rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>
                          
                        </div>

                        <div class="col-md-7">
                            <div class="row">
                                <div class="col">
                                    <label>Facebook Url</label>
                                    <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Facebook Url" />
                                </div>
                                <div class="col">
                                    <label>Twitter Url</label>
                                    <input type="text" id="twitter" name="twitter" class="form-control" placeholder="Twitter Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Instragram Url</label>
                                    <input type="text" id="instragram" name="instragram" class="form-control" placeholder="Instragram Url" />
                                </div>
                                <div class="col">
                                    <label>Youtube Url</label>
                                    <input type="text" id="youtube" name="youtube" class="form-control" placeholder="Youtube Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>E-mail Url</label>
                                    <input type="text" name="email" name="email" class="form-control" placeholder="E-mail Url" />
                                </div>

                                <div class="col">
                                    <label>Linkedin Url</label>
                                    <input type="text" id="linkedin" name="linkedin" class="form-control" placeholder="Linkedin Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>I-Tunes Url</label>
                                    <input type="text" id="itunes" name="itunes" class="form-control" placeholder="I-Tunes Url" />
                                </div>
                                <div class="col">
                                    <label>Bandcamp Url</label>
                                    <input type="text" id="bandcamp" name="bandcamp" class="form-control" placeholder="Bandcamp Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Disk Download Url</label>
                                    <input type="text" id="dsik_download" name="dsik_download" class="form-control" placeholder="Disk Download Url" />
                                </div>
                                <div class="col">
                                    <label>Spotify Url</label>
                                    <input type="text" id="spotify" name="spotify" class="form-control" placeholder="Spotify Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Apple Music Url</label>
                                    <input type="text" id="apple_music" name="apple_music" class="form-control" placeholder="Apple Music Url" />
                                </div>
                                <div class="col">
                                    <label>Sound Cloud Url</label>
                                    <input type="text" id="sound_cloud" name="sound_cloud" class="form-control" placeholder="Sound Cloud Url" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Personal Website Url</label>
                                    <input type="text" id="website" name="website" class="form-control" placeholder="Personl Website Url" />
                                </div>
                                <div class="col">
                                    <label>Here More Url</label>
                                    <input type="text" id="here_more_url" name="here_more_url" class="form-control" placeholder="Here More Url" />
                                </div>
                            </div>

                            <input type="hidden" name="epicArtists_id" id="epicArtists_id" />

                            <div class="modal-footer" style="float: right;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="imageUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/epic-artist/image-upload')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="image" required="" />
                    </div>
                    <input type="hidden" name="epick_artists_id" id="epick_artists_id" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="imageOneUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image One Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/epic-artist/image-one-upload')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="photo_one" required="" />
                    </div>
                    <input type="hidden" name="one_epick_artists_id" id="one_epick_artists_id" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="imageTwoUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Two Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/epic-artist/image-Two-upload')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="photo_two" required="" />
                    </div>
                    <input type="hidden" name="two_epick_artists_id" id="two_epick_artists_id" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="imageThreeUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Three Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/epic-artist/image-Three-upload')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="photo_three" required="" />
                    </div>
                    <input type="hidden" name="three_epick_artists_id" id="three_epick_artists_id" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="imageFourUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Four Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/epic-artist/image-Four-upload')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="photo_four" required="" />
                    </div>
                    <input type="hidden" name="four_epick_artists_id" id="four_epick_artists_id" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
@push('js')
<script type="text/javascript">
    function GetEpicArtistsData(id) {
        $.ajax({
            url: "get-epicArtistsId-data",
            type: "GET",
            data: {
                epicArtistsId: id,
            },
            success: function (data) {
                var all_data = JSON.parse(data);
                $("#modal-edit").modal("show");
                $("#epicArtists_id").val(all_data.id);
                $("#name").val(all_data.name);
                $("#about").val(all_data.about);
                $("#description").val(all_data.description);
                $("#music_speciality").val(all_data.music_speciality);
                $("#facebook").val(all_data.facebook);
                $("#instragram").val(all_data.instragram);
                $("#twitter").val(all_data.twitter);
                $("#youtube").val(all_data.youtube);
                $("#email").val(all_data.email);
                $("#linkedin").val(all_data.linkedin);
                $("#itunes").val(all_data.itunes);
                $("#bandcamp").val(all_data.bandcamp);
                $("#disk_download").val(all_data.disk_download);
                $("#spotify").val(all_data.spotify);
                $("#apple_music").val(all_data.apple_music);
                $("#sound_cloud").val(all_data.sound_cloud);
                $("#website").val(all_data.website);
                $("#here_more_url").val(all_data.here_more_url);
                $("#status").val(all_data.status);
            },
        });
    }
</script>
<script>
    function imageUpload(list) {
        $("#imageUpload").modal("show");
        $("#epick_artists_id").val(list);
    }
</script>
<script>
    function imageUpload(list) {
        $("#imageUpload").modal("show");
        $("#epick_artists_id").val(list);
    }
</script>
<script>
    function imageOneUpload(list) {
        $("#imageOneUpload").modal("show");
        $("#two_epick_artists_id").val(list);
    }
</script>
<script>
    function imageTwoUpload(list) {
        $("#imageTwoUpload").modal("show");
        $("#two_epick_artists_id").val(list);
    }
</script>
<script>
    function imageThreeUpload(list) {
        $("#imageThreeUpload").modal("show");
        $("#three_epick_artists_id").val(list);
    }
</script>
<script>
    function imageFourUpload(list) {
        $("#imageFourUpload").modal("show");
        $("#four_epick_artists_id").val(list);
    }
</script>
@endpush
