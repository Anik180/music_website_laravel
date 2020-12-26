@extends('backend.layout') @section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}" />
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
                        <h3 class="card-title">Update Title and Subtitle</h3>
                    </div>
                    <!-- /.card-header -->
                    <form method="POST" action="{{url('admin/credit/subtitle-update')}}">
                        @csrf
                        <div class="row"> 
                        <div class=" col-md-3"></div>
                         <div class="form-group col-md-6">
                        <label>Title<span class="required">*</span></label>
                        <input type="text" class="form-control" name="title_subtitle" value="{{$title_subtitle->value}}" required="">
                    </div>
                    <div class=" col-md-3"></div>
                    </div>
                      <button style="float: right;" type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp Update</button>
                    </form>
                </div>
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
                                    <th>Title</th>
                                    <th width="18%">Image</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($credits as $key=>$list)
                                <tr>
                                    <td>
                                        <form action="{{ url('admin/credits/sort-update') }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" name="id" value="{{ $list->id }}" required />
                                                <input type="number"  class="form-control" name="sort" value="{{ $list->sort }}" required />
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{ $list->title }}</td>
                                    <td>
                                        <img src="{{ ($list->image)? asset(config('app.f_url').'/storage/app/public/uploads/Credit/'.$list->image) : asset(config('app.f_url').'/default.jpg') }}" width="60" height="60" />
                                        <a href="{{ ($list->image)? asset(config('app.f_url').'/storage/app/public/uploads/Credit/'.$list->image) : asset(config('app.f_url').'/default.jpg') }}" class="btn btn-info btn-sm" title="Download" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                            @if($list->video==!NULL)
                                        <a href="{{ ($list->video)? asset(config('app.f_url').'/storage/app/public/uploads/CreditVideo/'.$list->video) : asset(config('app.f_url').'/default.jpg') }}" class="btn btn-info btn-sm" title="Video Download" download>
                                            <i class="fas fa-video"></i>
                                        </a>
                                           @else
                                            <a class="btn btn-info btn-sm" title="No Video">
                                            <i class="fas fa-video-slash"></i>
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a
                                            class="btn btn-info waves-effect btn-md"
                                            id="item_edit"
                                            href="javascript:void(0);"
                                            data-id="<?php echo $list->id; ?>"
                                            data-title="<?php echo $list->title; ?>"
                                            data-youtube_link="<?php echo $list->youtube_link; ?>"
                                            data-status="<?php echo $list->status; ?>"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/credits',$list->id)}}" method="post" style="display: none;">
                                            @method('DELETE') @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="15%">Sort</th>
                                    <th>Title</th>
                                    <th width="18%">Image</th>
                                    <th width="10%">Action</th>
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{$title}} Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" accept="{{url('admin/credits')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!--<div class="form-group">-->
                        <!--    <label>Title</label>-->
                        <!--    <input type="text" class="form-control" name="title" placeholder="Enter Title" />-->
                        <!--</div>-->
                        <div class="form-group">
                            <label>Title</label>
                            <textarea name="title" class="form-control textarea" placeholder="Enter Title"></textarea>
                         </div>
                        <div class="form-group">
                            <label>Youtube Link</label>
                            <input type="text" class="form-control" name="youtube_link" placeholder="Enter Youtube Link" />
                        </div>
                        <div class="form-group">
                            <label>Video File</label>
                            <input type="file" class="form-control" name="video" />
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" class="form-control" name="image" />
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

<div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Update {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" action="{{url('admin/credits-update')}}">
                @csrf
                <div class="modal-body">
                    <!--<div class="form-group">-->
                    <!--    <label>Title</label>-->
                    <!--    <input type="text" id="title" class="form-control" name="name" placeholder="Enter Name" />-->
                    <!--</div>-->
                     <div class="form-group">
                            <label>Title</label>
                            <textarea name="name" id="title" class="form-control textarea" placeholder="Enter Title">{!! $list->title !!}</textarea>
                         </div>
                    <div class="form-group">
                        <label>Youtube Link</label>
                        <input type="text" class="form-control" id="youtube_link" name="youtube_link" placeholder="Enter Youtube Link" />
                    </div>
                    <div class="form-group">
                        <label>Status<span class="required">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="2">In Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Video File</label>
                        <input type="file" class="form-control" name="video" />
                    </div>
                    <input type="hidden" name="credit_id" id="credit_id" />
                </div>
                <div class="modal-footer" style="float: right;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<div id="imageUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/credits/image-update')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="image" required="" />
                    </div>
                    <input type="hidden" name="credit_id" id="image_expertise_id" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection @push('js')

<script>
    function imageUpload(list) {
        $("#imageUpload").modal("show");
        $("#image_expertise_id").val(list);
    }
</script>
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        // Summernote
        $(".textarea").summernote();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("table").on("click", "#item_edit", function () {
            var id = $(this).data("id");
            var title = $(this).data("title");
            var youtube_link = $(this).data("youtube_link");
            var status = $(this).data("status");
            $("#modal-edit").modal("show");
            $("#credit_id").val(id);
            $("#title").val(title);
            $("#youtube_link").val(youtube_link);
            $("#status").val(status);
        });
    });
</script>
@endpush
