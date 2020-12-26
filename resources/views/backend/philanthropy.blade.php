@extends('backend.layout')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}">
<style type="text/css">
    .title2{
        text-transform: none;
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
                    <button type="button" class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add" title="Add"><i class="fas fa-plus-circle"></i> Add New</button>
                    <div class="modal fade" id="add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ url('admin/philanthropies') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Description<span class="required">*</span></label>
                                            <textarea name="desc" class="form-control textarea" placeholder="description" required=""></textarea>
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
                </div>
            </div>
            <!-- /.card-header -->
           <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                            <th width="15%">Sort</th>
                            <th>Desc</th>
                            <th width="20%">Action</th>
                  
                </tr>
                </thead>
                 <tbody>
                        @foreach($lists as $key=>$list)
                        <tr>
                            <td>
                                <form action="{{ url('admin/philanthropies-sort-update') }}" method="POST">
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
                            <td>{{ \Illuminate\Support\Str::limit($list->desc,100) }}</td>
                           
                            <td>
                                <button type="button" class="btn btn-md btn-md bg-gradient-info"  data-toggle="modal" data-target="#edit_{{$list->id}}" title="Edit"><i class="fas fa-edit"></i></button>
                          {{--       <button type="button" class="btn btn-md btn-md bg-gradient-danger" onclick="return (confirm('Are you sure?'))?document.getElementById('{{$list->id}}').submit():false" title="Delete"><i class="fas fa-trash"></i></button>
                                <form id="{{$list->id}}" action="{{ url('admin/philanthropies',$list->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                  <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                     <form id="delete-form-{{$list->id}}" action="{{url('admin/philanthropies',$list->id)}}" method="post" style="display: none;">
                                            @method('DELETE') @csrf
                                        </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit_{{$list->id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update {{$title}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ url('admin/philanthropies',$list->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Description<span class="required">*</span></label>
                                                <textarea name="desc" class="form-control textarea" placeholder="description" required="">{!!$list->desc!!}</textarea>
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
                        @endforeach
                    </tbody>
                <tfoot>
                <tr>
                            <th width="15%">Sort</th>
                            <th>Desc</th>
                            <th width="20%">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
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