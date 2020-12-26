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
                        <h3 class="card-title">Add New News</h3>
                    </div>
                    <form method="POST" action="{{url('admin/news-update',$news_list->id)}}" enctype="multipart/form-data">
                        @csrf
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                               <label>Pullish Date</label>
                               <input type="date" name="date" class="form-control" value="{{$news_list->publish_date}}" placeholder="DD/MM/YY" required="">
                           </div>
                           <div class="form-group">
                               <label>Post Title</label>
                               <input type="text" name="title" value="{{$news_list->title}}" class="form-control" placeholder="Enter Post Title" required="">
                           </div>
                            <div class="form-group">
                               <label>Title</label>
                               <input type="text" name="title_two" value="{{$news_list->title_two}}" class="form-control" placeholder="Enter Title">
                           </div>
                           <div class="form-group">
                               <label>Url</label>
                               <input type="text" name="url" value="{{$news_list->url}}" class="form-control" placeholder="Enter Post Url" required="">
                           </div>
                           <div class="form-group">
                              <label>Short Description</label>
                              <textarea class="form-control textarea" name="short_description" required="">{!! $news_list->short_description !!}</textarea>
                            </div>
                           <div class="form-group">
                               <label>Description</label>
                               <textarea class="form-control textarea" name="description" required="">{!! $news_list->description !!}</textarea>
                           </div>
                           <div class="form-group">
                              <label>youtube Link</label>
                              <input type="text" name="youtube_link" value="{{$news_list->youtube_link}}" class="form-control" placeholder="Enter Youtube Link">
                            </div>
                            <div class="form-group">
                              <label>Video</label>
                              <input type="file" class="form-control" name="video">
                            </div>
                            <div class="form-group">
                               <label>Single Post Meta Title</label>
                               <input type="text" name="meta_titles" value="{{$news_list->meta_titles}}" class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Single Post Meta Description</label>
                              <textarea class="form-control textarea" name="meta_description">{!! $news_list->meta_description !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Status<span class="required">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="card-footer" style="float: right;">
                            <button class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                        <!-- /.card-body -->
                    </form>
                    
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </section>

   
    </div>
    <!-- /.modal-dialog -->
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
@endpush