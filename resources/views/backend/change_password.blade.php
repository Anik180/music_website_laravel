@extends('backend.layout')
@section('css')
<style type="text/css">
    .title2{
        text-transform: none;
    }
   
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/summernote/summernote-bs4.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
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
        <div class="row">
            <div class="col-md-8" style="float: none;margin: 0 auto;">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $title }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('admin/change-password') }}">
                            @csrf
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" name="old_pass" value="{{ old('old_pass') }}" placeholder="Enter Old Password required">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_pass" value="{{ old('new_pass') }}" placeholder="Enter News Password" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="con_pass" value="{{ old('con_pass') }}" placeholder="Enter Confirm Password" required>
                            </div>
                            <div class="card-footer" style="float: right;">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-upload"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>

@endsection
@push('js')

@endpush