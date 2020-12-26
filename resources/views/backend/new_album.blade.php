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
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle"></i> Add New</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="15%">Sort</th>
                                    <th width="25%">Title</th>
                                    <th width="20%">Url</th>
                                    <th width="20%">Photo</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($new_album as $key=>$list)
                                <tr>
                                    <td>
                                        <form action="{{ url('admin/new-album-sort') }}" method="POST">
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
                                    <td>{{ $list->title }}</td>
                                    <td>{{ $list->url }}</td>
                                    <td>
                                        <img src="{{ ($list->photo)? asset(config('app.f_url').'/storage/app/public/uploads/newAlbum/'.$list->photo) : asset(config('app.f_url').'/default.jpg') }}" width="60" height="60">
                                        <a href="{{ ($list->photo)? asset(config('app.f_url').'/storage/app/public/uploads/newAlbum/'.$list->photo) : asset(config('app.f_url').'/default.jpg') }}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    <td>
                                        <a class="btn btn-info waves-effect btn-md" 
                                            id="item_edit" href="javascript:void(0);" 
                                            data-id="<?php echo $list->id; ?>" 
                                            data-title="<?php echo $list->title; ?>" 
                                            data-url="<?php echo $list->url; ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/new-album/delete',$list->id)}}" method="post" style="display: none;">
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
            <form method="POST" accept="{{url('admin/new-album')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Title">
                    </div>

                    <div class="form-group">
                        <label>Url</label>
                        <input type="text" class="form-control" name="url" placeholder="Enter Url">
                    </div>
                    
                    <div class="form-group">
                        <label>Photo<span class="required">*</span></label>
                        <input type="file" class="form-control" name="image" required="">
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
    <!-- update Modal -->
    <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Update {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{url('admin/new-album/update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" id="title" class="form-control" name="title" placeholder="Enter Title">
                            </div>

                            <div class="form-group">
                                <label>Url</label>
                                <input type="text" id="url" class="form-control" name="url" placeholder="Enter Url">
                            </div>
                            <input type="hidden" name="album_id" id="album_id">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
</div>
<div id="imageUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Image Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/new-album-image-update')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Photo <span class="required"></span></label>
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
@endsection
@push('js')
<script type="text/javascript">
$(document).ready(function(){
    $('table').on('click','#item_edit',function(){
        var id = $(this).data('id');
        var title = $(this).data('title');
        var url = $(this).data('url');
        $('#modal-edit').modal('show');
        $('#album_id').val(id);
        $('#title').val(title);    
        $('#url').val(url);    
    });
})
</script>
<script>
    function imageUpload(list){
        $('#imageUpload').modal('show');
        $('#image_expertise_id').val(list);
     }
</script>
@endpush