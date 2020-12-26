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
                      
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>E-Mail</th>
                                    <th>Company</th>
                                    <th>Company Type</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contact_us as $key=>$list)
                                <tr>
                                    <td>{{$list->user_type}}</td>
                                    <td>{{$list->first_name . ' '. $list->last_name}}</td>
                                    <td>{{$list->phone_number}}</td>
                                    <td>{{$list->email}}</td>
                                    <td>{{$list->company}}</td>
                                    <td>{{$list->company_type}}</td>
                                    <td>{{$list->message}}</td>
                                    <td>
                                        <button class="btn btn-danger waves-effect btn-sm" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/contact-us',$list->id)}}" method="post" style="display: none;">
                                            @method('delete') @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div align="center">
                            {!! $contact_us->links() !!}
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
  
    <!-- update Modal -->

    <!-- /.modal-dialog -->
    </div>
</div>

@endsection
@push('js')
<script type="text/javascript">

</script>
@endpush