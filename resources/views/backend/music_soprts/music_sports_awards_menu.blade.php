@extends('backend.layout') @section('css')
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
                        <h3 class="card-title">List</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Add New<i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="15%">Sort</th>
                                    <th>Title</th>
                                    <th>Url Link</th>
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($music_sports_awards_menu as $key=>$list)
                                <tr>
                                    <td>
                                        <form action="{{ url('admin/submit-sports-award-menu-sort') }}" method="POST">
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
                                    <td>{{($list->title)}}</td>
                                    <td>{{($list->url_link)}}</td>
                                    
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
                                        <a href="{{url('admin/submit-sports/awards-list/'.$list->id)}}" title="Track List" class="btn btn-warning btn-md"><i class="fa fa-medal"></i> Awards</a>
                                        <a class="btn btn-info waves-effect btn-md" 
                                            id="item_edit" href="javascript:void(0);" 
                                            data-id="<?php echo $list->id; ?>" 
                                            data-title="<?php echo $list->title; ?>" 
                                            data-url_link="<?php echo $list->url_link; ?>" 
                                            data-status="<?php echo $list->status; ?>" 
                                            >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/music-sports-awards-menu-destroy',$list->id)}}" method="post" style="display: none;">
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
            <form method="POST" action="{{url('admin/music-sports-awards-menu-store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" required="" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label>Url Link</label>
                        <input type="text" class="form-control" name="url_link" required="" placeholder="Enter Url Link">
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
    <!-- Add Modal -->
    <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Update {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{url('admin/submit-sports-award-menu-update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" id="title" name="title" required="" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label>Url Link</label>
                            <input type="text" class="form-control" id="url_link" name="url_link" required="" placeholder="Enter Url Link">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="2">In Active</option>
                            </select>
                        </div>
                        <input type="hidden" name="menu_id" id="menu_id">
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
        var url_link = $(this).data('url_link');
        var status = $(this).data('status');
        $('#modal-edit').modal('show');
        $('#menu_id').val(id);
        $('#title').val(title);
        $('#url_link').val(url_link);
        $('#status').val(status);
    });
})
</script>
@endpush