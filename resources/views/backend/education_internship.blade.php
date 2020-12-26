@extends('backend.layout')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
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
                                <form action="{{ url('admin/education-internships') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Descriptions</label>
                                            <textarea style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" class="textarea form-control" id="desc" name="desc" rows="5" placeholder="Description here">{{ old('desc') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Photo<span class="required">*</span></label>
                                            <input type="file" class="form-control" name="image" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                        <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Save</button>
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
                            <th style="width:15%">Sort</th>
                            <th>Title</th>
                            <th width="15%">Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($lists))
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>
                                <form action="{{ url('admin/education-internships-sort-update') }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="hidden" name="id" value="{{ $list->id }}" required>
                                        <input type="number" class="form-control" name="sort" value="{{ $list->sort }}" required>
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </td>
                            <td>{{ $list->title }}</td>
                            <td>
                                <img src="{{ ($list->image)?asset(config('app.f_url').'/storage/app/public/uploads/Education/'.$list->image) :asset(config('app.f_url').'/default.jpg')}}" width="60">
                                <a href="{{ ($list->image)?asset(config('app.f_url').'/storage/app/public/uploads/Education/'.$list->image) :asset(config('app.f_url').'/default.jpg')}}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-md btn-md bg-gradient-info"  data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                         {{--        <button type="button" class="btn btn-md btn-sm bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->id}}" action="{{ url('admin/education-internships',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/education-internships',$list->id)}}" method="post" style="display: none;">
                                            @method('DELETE') @csrf
                                        </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit_{{$list->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ url('admin/education-internships',$list->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{$title}}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="title">Title<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title',$list->title) }}" placeholder="Title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="desc">Descriptions</label>
                                                <textarea class="form-control textarea" id="desc" name="desc" rows="10" placeholder="Description here">{{ old('desc',$list->desc) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
    <div id="imageUpload" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Image Upload</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{url('admin/education-internships/image-update')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" class="form-control" name="image" required="">
                        </div>
                        <input type="hidden" name="ourExpertise_id" id="image_expertise_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
<script>
    function imageUpload(list){
        $('#imageUpload').modal('show');
        $('#image_expertise_id').val(list);
     }
</script>
@endpush