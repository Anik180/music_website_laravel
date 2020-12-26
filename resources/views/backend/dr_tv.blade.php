@extends('backend.layout') 
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}" />
<style type="text/css">
    .title2 {
        text-transform: none;
    }
</style>
@endsection @section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                     <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Drtv Sports Artits</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus-circle"></i> Add New</button>
                    <div class="modal fade" id="add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{url('admin/dr-tv-store')}}" enctype="multipart/form-data">
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
                                            <textarea class="form-control textarea"  name="title" rows="10" placeholder="Enter Name"></textarea>
                                        </div>
                                        <!--<div class="form-group">-->
                                        <!--    <label>About<span class="required">*</span></label>-->
                                        <!--    <textarea class="form-control" name="about" required placeholder="Enter About Artists"></textarea>-->
                                        <!--</div>-->
                                        <div class="form-group">
                                            <label>Here More Url</label>
                                            <input type="text" name="here_more_url" class="form-control" placeholder="Enter More Url" />
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
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="15%">Sort</th>
                            <th>Artist Name</th>
                            <!--<th>About</th>-->
                            <th>Images</th>
                            <th>Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dr_tv as $key=>$list)
                        <tr>
                            <td>
                                <form action="{{ url('admin/dr-tv-sort') }}" method="POST">
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
                                <img src="{{ ($list->photo)?asset(config('app.f_url').'/storage/app/public/uploads/Drtv/'.$list->photo) :asset(config('app.f_url').'/default.jpg')}}" width="60" />
                                <a href="{{ ($list->photo)?asset(config('app.f_url').'/storage/app/public/uploads/Drtv/'.$list->photo) :asset(config('app.f_url').'/default.jpg')}}" class="btn btn-info btn-sm" title="Download" download>
                                    <i class="fas fa-download"></i>
                                </a>
                                <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                            </td>
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
                                <a href="{{url('admin/dr-tv/music/'.$list->id)}}" title="DRTV Music" class="btn btn-warning btn-sm"><i class="fa fa-music"></i> Drtv Music</a>
                                <button type="button" class="btn btn-md btn-md bg-gradient-info" data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{url('admin/dr-tv-delete',$list->id)}}" method="post" style="display: none;">
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
                                        <form method="post" enctype="multipart/form-data" action="{{url('admin/dr-tv-image-upload')}}">
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
                                                <input type="hidden" name="dr_tv_id" value="{{$list->id}}" id="dr_tv_id_image" />
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
                                    <form method="POST" action="{{route('drtv.update',$list->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Title<span class="required">*</span></label>
                                                <input type="text" id="name" class="form-control" name="title" required="" value="{{$list->title}}" />
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
                                            {{-- <input type="hidden" name="dr_tv_id" id="dr_tv_id" /> --}}
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
                            <th>Artist Name</th>
                            <!--<th>About</th>-->
                            <th>Images</th>
                            <th>Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection @push('js')
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
@endpush
