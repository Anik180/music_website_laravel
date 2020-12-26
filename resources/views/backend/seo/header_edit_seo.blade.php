@extends('backend.layout')

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
        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/seo-update',$data->menu_name) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="post_title">Post Title</label>
                        <input type="text" class="form-control" id="post_title" name="post_title" value="{{ old('post_title', $data->post_title) }}" placeholder="Post title here">
                    </div>
                    <div class="form-group">
                        <label for="post_desc">Post Descriptions</label>
                        <textarea class="form-control textarea" id="post_desc" name="post_desc" rows="10" placeholder="Post descriptions here">{!! old('post_desc', $data->post_desc) !!}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Update</button>
                    {{-- <a href="{{ url('admin/blogs?blog_bn=0') }}" class="btn btn-warning float-right"><i class="fas fa-arrow-left"></i> Back</a> --}}
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}">
@endsection
@push('js')
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
@endpush