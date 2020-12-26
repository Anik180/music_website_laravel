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
     <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}} List</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus-circle"></i> Add New</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
         
                                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Track Name</th>
                                    <th>Track</th>
                                    <th>Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Sport_music_list as $key=>$list)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$list->name}}</td>
                                    <td>
                                        <img src="https://cdn0.iconfinder.com/data/icons/music-audio-video-flat-square-rounded-vol-1/150/audio__mp3__music__song-512.png" height="40">
                                        <a href="{{ asset(config('app.f_url').'/storage/app/public/uploads/Drtv/'.$list->music) }}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    <td>
                                        @if($list->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button>
                                        @else
                                        <button class="btn btn-danger btn-sm">In Active</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info waves-effect btn-md" id="item_edit" href="javascript:void(0);" 
                                            data-id="<?php echo $list->id; ?>" 
                                            data-name="<?php echo $list->name; ?>" 
                                            data-status="<?php echo $list->status; ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/sports-artist/music-delete',$list->id)}}" method="post" style="display: none;">
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
    
    
    
        <div class="modal fade" id="addModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$title}} Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{url('admin/sports-artist/music-store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name<span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" required="" placeholder="Enter Name">
                    </div>
                    
                    <div class="form-group">
                        <label>Music</label>
                        <input type="file" class="form-control" name="music">
                    </div>
                    <input type="hidden" name="sport_artist_id" value="{{$sport_artist_id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
     <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Update {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{url('admin/sports-artist/music-update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name<span class="required">*</span></label>
                                <input type="text" id="name" class="form-control" name="name" required="" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label>Status<span class="required">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>
                            <input type="hidden" name="track_list_id" id="track_list_id">
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
    </div>
    
</div>
<div id="imageUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Music Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{url('admin/sports-artist/music-upload')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Music</label>
                        <input type="file" class="form-control" name="music" required="">
                    </div>
                    <input type="hidden" name="track_list_id" id="music_track_list_id">
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
        var name = $(this).data('name');
        var status = $(this).data('status');
        $('#modal-edit').modal('show');
        $('#track_list_id').val(id);
        $('#name').val(name);
        $('#status').val(status);
    });
})
</script>
<script>
    function imageUpload(list){
        console.log(list);
        $('#imageUpload').modal('show');
        $('#music_track_list_id').val(list);
     }
</script>
@endpush