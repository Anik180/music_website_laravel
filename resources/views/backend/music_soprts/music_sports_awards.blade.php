@extends('backend.layout')
@section('css')
<style type="text/css">
    .modal-lg,
    .modal-xl {
        max-width: 90% !important;
    }
</style>
@endsection @section('content')
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
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Add New <i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="15%">Sort</th>
                                    <th>Awards Menu Name</th>
                                    <th>title</th>
                                    <th>Sub Title</th>
                                    <th>Licensed Music</th>
                                    <th>description</th>
                                    <th>Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($music_sports_awards as $key=>$list)
                                <tr>
                                    <td>
                                        <form action="{{ url('admin/submit-sports-award-sort') }}" method="POST">
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
                                    <td>{{($list->music_sports_awards_menus_id)}}</td>
                                    <td>{{($list->title)}}</td>
                                    <td>{{($list->sub_title)}}</td>
                                    <td>{{($list->best_music)}}</td>
                                    <td>{{($list->description)}}</td>
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
                                            id="item_edit" href="javascript:void(0);" 
                                            data-id="<?php echo $list->id; ?>" 
                                            data-title="<?php echo $list->title; ?>" 
                                            data-sub_title="<?php echo $list->sub_title; ?>" 
                                            data-best_music="<?php echo $list->best_music; ?>" 
                                            data-description="<?php echo $list->description; ?>" 
                                            data-video_link="<?php echo $list->video_link; ?>" 
                                            data-status="<?php echo $list->status; ?>" 
                                            >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/music-sports-awards-destroy',$list->id)}}" method="post" style="display: none;">
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$title}} Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{url('admin/music-sports-awards-store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                       <label>Title</label>
                       <input type="text" name="title" class="form-control" placeholder="Enter Title" required="">
                   </div>
                   <div class="form-group">
                       <label>Sub Title</label>
                       <input type="text" name="sub_title" class="form-control" placeholder="Enter Sub Title">
                   </div>
                   <div class="form-group">
                       <label>Licensed Music</label>
                       <input type="text" name="best_music" class="form-control" placeholder="Enter Licensed Music">
                   </div>
                   <div class="form-group">
                       <label>Description</label>
                       <textarea class="form-control textarea" rows="4" name="description" required=""></textarea>
                   </div>
                   <div class="form-group">
                       <label>Video Link</label>
                       <input type="text" name="video_link" class="form-control" placeholder="Enter Video Link">
                   </div>
                    <div class="form-group">
                       <label>Video</label>
                       <input type="file" name="image" class="form-control">
                   </div>
                   <input type="hidden" name="menu_id" value="{{$menu_id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Update {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{url('admin/submit-sports-award-update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                           <label>Title</label>
                           <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title" required="">
                       </div>
                       <div class="form-group">
                           <label>Sub Title</label>
                           <input type="text" id="sub_title" name="sub_title" class="form-control" placeholder="Enter Sub Title">
                       </div>
                       <div class="form-group">
                       <label>Licensed Music</label>
                       <input type="text" name="best_music" class="form-control" placeholder="Enter Licensed Music">
                   </div>
                       <div class="form-group">
                           <label>Description</label>
                           <textarea id="description" class="form-control" rows="4" name="description" required=""></textarea>
                       </div>
                       <div class="form-group">
                           <label>Video Link</label>
                           <input type="text" id="video_link" name="video_link" class="form-control" placeholder="Enter Video Link">
                       </div>
                        
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="2">In Active</option>
                            </select>
                        </div>
                        <input type="hidden" name="awards_id" id="awards_id">
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

@endsection @push('js')
<script type="text/javascript">
$(document).ready(function(){
    $('table').on('click','#item_edit',function(){
        var id = $(this).data('id');
        var title = $(this).data('title');
        var sub_title = $(this).data('sub_title');
        var best_music = $(this).data('best_music');
        var description = $(this).data('description');
        var video_link = $(this).data('video_link');
        var status = $(this).data('status');
        $('#modal-edit').modal('show');
        $('#awards_id').val(id);
        $('#title').val(title);
        $('#sub_title').val(sub_title);
        $('#best_music').val(best_music);
        $('#description').val(description);
        $('#video_link').val(video_link);
        $('#status').val(status);
    });
})
</script>
@endpush