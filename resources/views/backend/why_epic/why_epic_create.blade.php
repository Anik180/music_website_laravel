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
                        <h3 class="card-title">Add New {{$title}}</h3>
                    </div>
                    <form method="POST" action="{{url('admin/why-epic-create')}}" enctype="multipart/form-data">
                        @csrf
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                              <label>Epic Type</label>
                              <select name="type" id="type" class="form-control" required="" onchange="getOurProcess()">
                                <option value="">Select Epic Type</option>
                                <option value="MESSAGE FROM CEO">MESSAGE FROM CEO</option>
                                <option value="OUR PHILOSOPHY">OUR PHILOSOPHY</option>
                                <option value="OUR PROCESS">OUR PROCESS</option>
                              </select>
                           </div>
                           <div class="form-group" id="our_process_type_div">
                              <label>Our Process Type</label>
                              <select name="our_process_type" class="form-control" id="our_process_type">
                                <option value="">Select Our Process Type</option>
                                <option value="Learn">Learn</option>
                                <option value="Connect">Connect</option>
                                <option value="Collaborate">Collaborate</option>
                                <option value="Develop">Develop</option>
                                <option value="Deliver">Deliver</option>
                              </select>
                           </div>
                          
                           <div class="form-group">
                               <label>Description</label>
                               <textarea class="form-control textarea" rows="4" name="description" required=""></textarea>
                           </div>
                        </div>
                        <div class="card-footer" style="float: right;">
                            <button class="btn btn-primary">Save Changes</button>
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
<script>
    $( document ).ready(function() {
        $('#our_process_type_div').css('display','none')
    });
    function getOurProcess()
    {
        let type_val = $('#type').val();
        if(type_val == 'OUR PROCESS'){
            $('#our_process_type_div').css('display','block')
            $('#our_process_type').attr('required',true)
        }else{
            $('#our_process_type_div').css('display','none')
            $('#our_process_type').attr('required',false) 
        }
    }
</script>
@endpush