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
                    <form method="POST" action="{{url('admin/why-epic-update',$why_epic->id)}}" enctype="multipart/form-data">
                        @csrf
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                              <label>Epic Type</label>
                              <select name="type" class="form-control" required="">
                                <option value="">Select Epic Type</option>
                                <option value="MESSAGE FROM CEO" {{($why_epic->epic_type == 'MESSAGE FROM CEO')? 'selected':''}}>MESSAGE FROM CEO</option>
                                <option value="OUR PHILOSOPHY" {{($why_epic->epic_type == 'OUR PHILOSOPHY')? 'selected':''}}>OUR PHILOSOPHY</option>
                                <option value="OUR PROCESS" {{($why_epic->epic_type == 'OUR PROCESS')? 'selected':''}}>OUR PROCESS</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <label>Our Process Type</label>
                              <select name="our_process_type" class="form-control" id="our_process_type">
                                <option value="">Select Our Process Type</option>
                                <option value="Learn" {{($why_epic->our_process_type == 'Learn')? 'selected':''}}>Learn</option>
                                <option value="Connect" {{($why_epic->our_process_type == 'Connect')? 'selected':''}}>Connect</option>
                                <option value="Collaborate" {{($why_epic->our_process_type == 'Collaborate')? 'selected':''}}>Collaborate</option>
                                <option value="Develop" {{($why_epic->our_process_type == 'Develop')? 'selected':''}}>Develop</option>
                                <option value="Deliver" {{($why_epic->our_process_type == 'Deliver')? 'selected':''}}>Deliver</option>
                              </select>
                           </div>
                          
                           <div class="form-group">
                               <label>Description</label>
                               <textarea class="form-control textarea" rows="4" name="description" required="">{!! $why_epic->description !!}</textarea>
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
@endpush