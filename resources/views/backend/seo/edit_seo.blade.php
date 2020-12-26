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
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $data->meta_title) }}" placeholder="Meta title here">
                    </div>
                    <div class="form-group">
                        <label for="meta_desc">Meta Descriptions</label>
                        <textarea class="form-control" id="meta_desc" name="meta_desc" rows="10" placeholder="Meta descriptions here">{{ old('meta_desc', $data->meta_desc) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="meta_key">Meta Keywords</label>
                        <textarea class="form-control" id="meta_key" name="meta_key" rows="10" placeholder="Meta keywords here">{{ old('meta_key', $data->meta_key) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="header_code">Header Code</label>
                        <textarea class="form-control" id="header_code" name="header_code" rows="10" placeholder="Header code here">{{ old('header_code', $data->header_code) }}</textarea>
                    </div>                    
                    <div class="form-group">
                        <label for="header_code">Body Code</label>
                        <textarea class="form-control" id="body_code" name="body_code" rows="10" placeholder="Body code here">{{ old('body_code', $data->body_code) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="post_title">Post Title</label>
                        <input type="text" class="form-control" id="post_title" name="post_title" value="{{ old('post_title', $data->post_title) }}" placeholder="Post title here">
                    </div>
                    <div class="form-group">
                        <label for="post_desc">Post Descriptions</label>
                        <textarea class="form-control textarea" id="post_desc" name="post_desc" rows="10" placeholder="Post descriptions here">{!! old('post_desc', $data->post_desc) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="footer_title">Footer Title</label>
                        <input type="text" class="form-control" id="footer_title" name="footer_title" value="{{ old('footer_title', $data->footer_title) }}" placeholder="Footer title here">
                    </div>
                    <div class="form-group">
                        <label for="footer_desc">Footer Descriptions</label>
                        <textarea class="form-control textarea" id="footer_desc" name="footer_desc" rows="10" placeholder="Footer descriptions here">{!! old('footer_desc', $data->footer_desc) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="footer_title_2">Footer Title 2</label>
                        <input type="text" class="form-control" id="footer_title_2" name="footer_title_2" value="{{ old('footer_title_2', $data->footer_title_2) }}" placeholder="Footer title here">
                    </div>
                    <div class="form-group">
                        <label for="footer_desc_2">Footer Descriptions 2</label>
                        <textarea class="form-control textarea" id="footer_desc_2" name="footer_desc_2" rows="10" placeholder="Footer descriptions here">{!! old('footer_desc_2', $data->footer_desc_2) !!}</textarea>
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