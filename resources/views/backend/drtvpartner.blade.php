@extends('backend.layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>About Drtv</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">DrTv Partnership</li>
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
                <h3 class="card-title">DrTv Partnership</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('update.drtvpart',$drtvpart->id)}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" class="form-control" name="title" value="{{$drtvpart->title}}" placeholder="Post title here">
                    </div>
                    <div class="form-group">
                        <label for="post_desc">Descriptions</label>
                        <textarea class="form-control textarea"  name="description" rows="10" placeholder="Post descriptions here">{!! $drtvpart->description !!}</textarea>
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