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
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus"></i> Add</button>
                    <div class="modal fade" id="add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ url('admin/seos') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="menu">Menu<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="menu" name="menu" placeholder="menu" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Descriptions<span class="required">*</span></label>
                                            <textarea class="form-control" id="desc" name="desc" rows="5" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="key">Keywords<span class="required">*</span></label>
                                            <textarea class="form-control" id="key" name="key" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                        <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Menu</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($seos))
                        @foreach($seos as $key => $seo)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $seo->seo_menu }}</td>
                            <td>{{ $seo->seo_title }}</td>
                            <td>
                                <button type="button" class="btn btn-md bg-gradient-primary"  data-toggle="modal" data-target="#edit_{{$seo->seo_id}}" title="Edit"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-md bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$seo->seo_id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$seo->seo_id}}" action="{{ url('admin/seos',$seo->seo_id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit_{{$seo->seo_id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ url('admin/seos',$seo->seo_id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{$title}}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="menu">Menu</label>
                                                <input type="text" class="form-control" id="menu" name="menu" value="{{$seo->seo_menu}}" placeholder="title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="{{$seo->seo_title}}" placeholder="title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="desc">Descriptions</label>
                                                <textarea class="form-control" id="desc" name="desc" rows="5" required>{{$seo->seo_desc}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="key">Keywords</label>
                                                <textarea class="form-control" id="key" name="key" rows="5" required>{{$seo->seo_keywords}}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection