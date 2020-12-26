@extends('backend.layout')
@section('css')
<style type="text/css">
    .title2{
        text-transform: none;
    }
   
</style>
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
                                <form method="POST" action="{{url('admin/why-epic/client-say-store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Saying <span class="required"></span></label>
                                            <textarea name="desc" class="form-control textarea" placeholder="description" required=""></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Photo</label>
                                            <input type="file" class="form-control" name="image">
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
                            <th>Desc</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client_say as $key=>$list)
                        <tr>
                            <td>
                                <form action="{{ url('admin/why-epic/client-say-sort') }}" method="POST">
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
                            <td style="color: black !important;">{!! $list->desc !!}</td>
                            <td>
                                <img src="{{ ($list->image)?asset(config('app.f_url').'/storage/app/public/uploads/ClientSays/'.$list->image) :asset(config('app.f_url').'/default.jpg')}}" width="60">
                                <a href="{{ ($list->image)?asset(config('app.f_url').'/storage/app/public/uploads/ClientSays/'.$list->image) :asset(config('app.f_url').'/default.jpg')}}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                            </td>
                            <td>
                                @if($list->status == 1)
                                <button class="btn btn-primary btn-sm">Active</button>
                                @else
                                <button class="btn btn-danger btn-sm">In Active</button>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-md btn-sm bg-gradient-info"  data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger waves-effect btn-sm" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                <form id="delete-form-{{$list->id}}" action="{{url('admin/why-epic/client-say-delete',$list->id)}}" method="post" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit_{{$list->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{url('admin/why-epic/client-say-update')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Saying<span class="required">*</span></label>
                                                    <textarea name="desc" class="form-control textarea" placeholder="Description" required="">{!! $list->desc !!}</textarea>
                                                </div>                    
                                                <div class="form-group">
                                                    <label>Status<span class="required">*</span></label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="1" {{ ($list->status == 1) ? 'selected':'' }}>Active</option>
                                                        <option value="2" {{ ($list->status == 2) ? 'selected':'' }}>In Active</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="client_say_id" value="{{$list->id}}">
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<div id="imageUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/client-say/image-update')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="image" required="">
                    </div>
                    <input type="hidden" name="clent_says_id" id="image_expertise_id">
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