@extends('backend.layout') 
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}" />
<style type="text/css">
    .title2 {
        text-transform: none;
    }
</style>
@endsection
@section('content')
@php
	   $sportsteam=DB::table('sport_teams')->first();
@endphp
<div class="content-wrapper">
     <!-- Content Header (Page header) -->
         <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>About Sports Composer team</h1>
                </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
        <section class="content">
        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">About Sports Composer team</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('update.sportsteam',$sportsteam->id)}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{$sportsteam->title}}" placeholder="Post title here">
                    </div>
                    <div class="form-group">
                        <label for="post_desc">Descriptions</label>
                        <textarea class="form-control textarea"  name="description" rows="10" placeholder="Post descriptions here">{!! $sportsteam->description !!}</textarea>
                    </div>
                    
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Update</button>
     
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section> 
    <section class="content">
                <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus-circle"></i> Add New</button>
                    <div class="modal fade" id="add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{url('admin/sports-artist-store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Title<span class="required">*</span></label>
                                            <!--<input type="text" class="form-control" name="name" required="" placeholder="Enter Name" />-->
                                            <textarea class="form-control textarea"  name="name" rows="10" placeholder="Enter Name"></textarea>
                                        </div>
                                        <!--<div class="form-group">-->
                                        <!--    <label>About<span class="required">*</span></label>-->
                                        <!--    <textarea class="form-control" name="about" required placeholder="Enter About Artists"></textarea>-->
                                        <!--</div>-->
                                        <div class="form-group">
                                            <label>More Url</label>
                                            <input type="text" name="more_url" class="form-control" placeholder="Enter More Url" />
                                        </div>
                                        <div class="form-group">
                                            <label>Photo</label>
                                            <input type="file" class="form-control" name="photo" />
                                        </div>
                                        <div class="form-group">
                                            <label>Photo One</label>
                                            <input type="file" class="form-control" name="photo_one" />
                                        </div>
                                         <div class="form-group">
                                            <label>Photo Two</label>
                                            <input type="file" class="form-control" name="photo_two" />
                                        </div>
                                         <div class="form-group">
                                            <label>Photo Three</label>
                                            <input type="file" class="form-control" name="photo_three" />
                                        </div>
                                         <div class="form-group">
                                            <label>Photo Four</label>
                                            <input type="file" class="form-control" name="photo_four" />
                                        </div>
                                        <div class="form-group">
                                            <label>Description<span class="required">*</span></label>
                                            <textarea name="description" class="form-control textarea" placeholder="description" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                      <th width="15%">Sort</th>
                      <th width="10%">Artist Name</th>
                      <!--<th>About</th>-->
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
                        @foreach($Sports as $key=>$list)
                        <tr>
                            <td>
                                <form action="{{ url('admin/sports-artist-sort') }}" method="POST">
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

                            <td>{{($list->title)}}</td>
                            <!--<td>{{($list->about)}}</td>-->

                            <td>
                                <img src="{{ ($list->photo)?asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                <a href="{{ ($list->photo)?asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo) :asset(config('app.f_url').'/default.jpg')}}" class="btn btn-info btn-sm" title="Download" download>
                                    <i class="fas fa-download"></i>
                                </a>
                                <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                            </td>
                              @if($list->photo_one==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>
                                        
                                    </td>
                                     
                                     @else
                                    <td>
                                        <img src="{{ ($list->photo_one)?asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_one) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_one) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                         <button class="btn btn-info btn-sm" onclick="imageOneUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                 
                                    </td>
                                    @endif
                                  
                                     @if($list->photo_two==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                    @else
                                    <td>
                                        <img src="{{ ($list->photo_two)?asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_two) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_two) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                         <button class="btn btn-info btn-sm" onclick="imageTwoUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    @endif
                                     @if($list->photo_three ==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                    @else
                                         <td>
                                        <img src="{{ ($list->photo_three)?asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_three) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_three) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageThreeUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    @endif
                                    @if($list->photo_four==NULL)
                                    <td>
                                     <span class="badge btn-danger">No Photo</span>   
                                    </td>
                                    @else   
                                      <td>
                                        <img src="{{ ($list->photo_four)?asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_four) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/SportArtist/'.$list->photo_four) }}" class="btn btn-success btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageFourUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    @endif
                            {{--
                            <td>{{($list->photo) ? asset('uploads/epicArtists/'.$list->photo) :'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/1200px-Circle-icons-profile.svg.png'}}</td>
                            <td>--}}</td>
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
                                <a href="{{url('admin/sports-artist/music/'.$list->id)}}" title="Sports Music" class="btn btn-warning btn-sm"><i class="fa fa-music"></i> Sports Music</a>
                                <button type="button" class="btn btn-md btn-md bg-gradient-info" data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{url('admin/sports-artist-delete',$list->id)}}" method="post" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                            <div id="imageUpload_{{$list->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Image Upload</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data" action="{{url('admin/sports-artist-image-upload')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" value="{{$list->img_title}}" class="form-control" name="title" placeholder="Image Title" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt</label>
                                                    <input type="text" id="img_alt" value="{{$list->img_alt}}" class="form-control" name="alt" placeholder="Image Alt" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Url</label>
                                                    <input type="text" class="form-control" name="url" placeholder="Image Url" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Photo<span class="required">*</span></label>
                                                    <input type="file" class="form-control" name="image" required="" />
                                                </div>
                                                <input type="hidden" name="sports_artist_id" value="{{$list->id}}" id="sports_artist_id_image" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                 
                               <div id="imageOneUpload_{{$list->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Image One Upload</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data" action="{{url('admin/sports-artist-image-one-upload')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" value="{{$list->img_one_title}}" class="form-control" name="img_one_title" placeholder="Image  Title" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt</label>
                                                    <input type="text" id="img_one_alt" value="{{$list->img_one_alt}}" class="form-control" name="img_one_alt" placeholder="Image Alt" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Url</label>
                                                    <input type="text" class="form-control" name="one_url" placeholder="Image Url" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Photo<span class="required">*</span></label>
                                                    <input type="file" class="form-control" name="photo_one" required="" />
                                                </div>
                                                <input type="hidden" name="sports_artist_one_id" value="{{$list->id}}" id="sports_artist_id_image_one" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                 <div id="imageTwoUpload_{{$list->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Image Two Upload</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data" action="{{url('admin/sports-artist-image-two-upload')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" value="{{$list->img_two_title}}" class="form-control" name="img_two_title" placeholder="Image  Title" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt</label>
                                                    <input type="text" id="img_two_alt" value="{{$list->img_two_alt}}" class="form-control" name="alt" placeholder="Image Alt" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Url</label>
                                                    <input type="text" class="form-control" name="two_url" placeholder="Image Url" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Photo<span class="required">*</span></label>
                                                    <input type="file" class="form-control" name="photo_two" required="" />
                                                </div>
                                                <input type="hidden" name="sports_artist_two_id" value="{{$list->id}}" id="sports_artist_id_image_two" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                         <div id="imageThreeUpload_{{$list->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Image Three Upload</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data" action="{{url('admin/sports-artist-image-three-upload')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" value="{{$list->img_three_title}}" class="form-control" name="img_three_title" placeholder="Image  Title" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt</label>
                                                    <input type="text" id="img_three_alt" value="{{$list->img_three_alt}}" class="form-control" name="img_three_alt" placeholder="Image Alt" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Url</label>
                                                    <input type="text" class="form-control" name="three_url" placeholder="Image Url" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Photo<span class="required">*</span></label>
                                                    <input type="file" class="form-control" name="photo_three" required="" />
                                                </div>
                                                <input type="hidden" name="sports_artist_three_id" value="{{$list->id}}" id="sports_artist_id_image_three" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                   <div id="imageFourUpload_{{$list->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Image Four Upload</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data" action="{{url('admin/sports-artist-image-four-upload')}}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" value="{{$list->img_four_title}}" class="form-control" name="title" placeholder="Image  Title" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt</label>
                                                    <input type="text" id="img_alt" value="{{$list->img_four_alt}}" class="form-control" name="alt" placeholder="Image Alt" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Url</label>
                                                    <input type="text" class="form-control" name="four_url" placeholder="Image Url" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Photo<span class="required">*</span></label>
                                                    <input type="file" class="form-control" name="photo_four" required="" />
                                                </div>
                                                <input type="hidden" name="sports_artist_four_id" value="{{$list->id}}" id="sports_artist_id_image_four" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <div class="modal fade" id="edit_{{$list->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update {{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{route('admin.sports-artist-update',$list->id)}}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Title<span class="required">*</span></label>
                                                <input type="text" id="title" class="form-control" name="title" required="" value="{{$list->title}}" />
                                            </div>
                                            <!--<div class="form-group">-->
                                            <!--    <label>About<span class="required">*</span></label>-->
                                            <!--    <textarea class="form-control" id="about" name="about" required placeholder="Enter About Artists">{!!$list->title!!}</textarea>-->
                                            <!--</div>-->
                                            <div class="form-group">
                                                <label>Description<span class="required">*</span></label>
                                                <textarea class="form-control textarea" id="description" name="description" required placeholder="Enter Description">{!!$list->description!!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>More Url</label>
                                                <input type="text" name="here_more_url" id="here_more_url" class="form-control" value="{{$list->here_more_url}}" />
                                            </div>
                                            <div class="form-group">
                                                <label>Status<span class="required">*</span></label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="2">In Active</option>
                                                </select>
                                            </div>
                                            <!--<input type="hidden" name="sports_artis_id" id="sports_artis_id" />-->
                                        </div>
                                        <div class="modal-footer" style="float: right;">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                      <th width="15%">Sort</th>
                      <th width="10%">Artist Name</th>
                      <!--<th>About</th>-->
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
        
    </section>
</div>


@endsection 
@push('js')
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        // Summernote
        $(".textarea").summernote();
    });
</script>
<script>
    function imageUpload(list) {
        $("#imageUpload_" + list).modal("show");
    }
</script>
<script>
    function imageOneUpload(list) {
        $("#imageOneUpload_" + list).modal("show");
    }
</script>
<script>
    function imageTwoUpload(list) {
        $("#imageTwoUpload_" + list).modal("show");
    }
</script>
<script>
    function imageThreeUpload(list) {
        $("#imageThreeUpload_" + list).modal("show");
    }
</script>
<script>
    function imageFourUpload(list) {
        $("#imageFourUpload_" + list).modal("show");
    }
</script>

@endpush