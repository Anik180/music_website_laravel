@extends('backend.layout')
@section('css')
<style type="text/css">
    .card-body{
        padding: 0px;
    }
</style>
@endsection
@section('content')
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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="POST" action="{{url('admin/submit-music/update')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title 1<span class="required">*</span></label>
                                        <input type="text" id="title_1" value="{{$submit_music->title_1}}" class="form-control" name="title_1" required="" placeholder="Enter Title 1">
                                    </div>
                                    <div class="form-group">
                                        <label>Url 1<span class="required">*</span></label>
                                        <input type="text" id="url_1" value="{{$submit_music->url_1}}" class="form-control" name="url_1" required="" placeholder="Enter Url 1">
                                    </div>

                                    <div class="form-group">
                                        <label>Title 2<span class="required">*</span></label>
                                        <input type="text" id="title_2" value="{{$submit_music->title_2}}" class="form-control" name="title_2" required="" placeholder="Enter Title 2">
                                    </div>
                                    <div class="form-group">
                                        <label>Url 2<span class="required">*</span></label>
                                        <input type="text" id="url_2" value="{{$submit_music->url_2}}" class="form-control" name="url_2" required="" placeholder="Enter Url 2">
                                    </div>
                                   
                                    <input type="hidden" name="submit_music_id" value="{{$submit_music->id}}">
                                </div>
                                <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                                </div>
                            </div>
                        </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection
@push('js')


@endpush