@extends('backend.layout')

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
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <a href="{{ url('admin/news-create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create News</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="15%">Sort</th>
                                    <th width="25%">Post Title</th>
                                    <th width="25%">Title</th>
                                    <th width="20%">Url</th>
                                    <th width="20%">Photo</th>
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($news_list as $key=>$list)
                                <tr>
                                    <td>
                                        <form action="{{ url('admin/news-sort') }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" name="id" value="{{ $list->id }}" required>
                                                <input type="number" min="0" class="form-control" name="sort" value="{{ $list->sort }}" required>
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{($list->title)}}</td>
                                    <td>{{($list->title_two)}}</td>
                                    <td>{{($list->url)}}</td>
                                    <td>
                                        <img src="{{ ($list->photo)? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$list->photo) :asset(config('app.f_url').'/default.png')}}" width="60">
                                        <a href="{{ ($list->photo)? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$list->photo) :asset(config('app.f_url').'/default.png') }}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                         @if($list->video==!NULL)
                                        <a href="{{ ($list->video)? asset(config('app.f_url').'/storage/app/public/uploads/News/'.$list->video) : asset(config('app.f_url').'/default.jpg') }}" class="btn btn-info btn-sm" title="Video Download" download>
                                            <i class="fas fa-video"></i>
                                        </a>
                                         @else
                                            <a class="btn btn-info btn-sm" title="No Video">
                                            <i class="fas fa-video-slash"></i>
                                        </a>
                                        @endif
                                    </td>
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
                                        <a class="btn btn-info waves-effect btn-md" 
                                            id="item_edit" href="{{url('admin/news-edit/'.$list->id)}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/news/delete',$list->id)}}" method="post" style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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
    <div id="imageUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/news-image-update')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="image" required="">
                    </div>
                    <input type="hidden" name="news_id" id="image_expertise_id">
                    <div class="form-group">
                        <label>Image Alt</label>
                        <input type="text" name="image_alt" class="form-control" placeholder="Enter Image Alt">
                    </div>
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
</div>

@endsection
@push('js')
<script>
    function imageUpload(list){
        $('#imageUpload').modal('show');
        $('#image_expertise_id').val(list);
     }
</script>
@endpush