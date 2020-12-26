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
               <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal" style="margin-right: 5px;">
                    <i class="fas fa-plus-circle"></i>Add New
                  </button>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="15%">Sort</th>
                <th>Title</th>
                <th>Description</th>
                <th width="15%">Photo</th>
                <th>outside_link</th>
                <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                    @foreach($our_expertise as $key=>$list)
                <tr>
                    <td>
                        <form action="{{ url('admin/our-expertise-sort') }}" method="POST">
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
                                    <td>{{ \Illuminate\Support\Str::limit($list->description, 30, '...') }}</td>
                                    <td>
                                        <img src="{{ ($list->image)?asset('/storage/app/public/uploads/OurExpertise/'.$list->image) :asset(config('app.f_url').'/default.jpg')}}" width="60">
                                        <a href="{{ ($list->image)?asset('/storage/app/public/uploads/OurExpertise/'.$list->image) :asset(config('app.f_url').'/default.jpg')}}" class="btn btn-info btn-sm" title="Download" download><i class="fas fa-download"></i></a>
                                        <button class="btn btn-info btn-sm" onclick="imageUpload(<?php echo $list->id; ?>)" title="Upload"><i class="fa fa-upload"></i></button>
                                    </td>
                                    <td>{{($list->outside_link)}}</td>
                                    <td>
                                        <a class="btn btn-info waves-effect btn-md" id="item_edit" title="Edit" href="javascript:void(0);" 
                                            data-id="<?php echo $list->id; ?>" 
                                            data-title="<?php echo $list->title; ?>" 
                                            data-description="<?php echo $list->description; ?>" 
                                            data-outside_link="<?php echo $list->outside_link; ?>" 
                                            data-status="<?php echo $list->status; ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)" title="Delete"><i class="fa fa-trash"></i></button>
                                        <form id="delete-form-{{$list->id}}" action="{{url('admin/our-expertise',$list->id)}}" method="post" style="display: none;">
                                            @method('delete') 
                                            @csrf
                                        </form>
                                    </td>
                </tr>
               @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th width="15%">Sort</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th width="15%">Photo</th>
                    <th>outside_link</th>
                    <th>Action</th>
                </tr>
                </tfoot>
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
            <form method="POST" accept="{{url('admin/our-expertise')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title<span class="required">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Title" required="">
                    </div>
                    <div class="form-group">
                        <label>Outside Link</label>
                        <input type="text" class="form-control" name="outside_link" placeholder="Enter Outside Link">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control" name="image">
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
                <form method="POST" action="{{url('admin/our-expertise-update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title<span class="required">*</span></label>
                                <input type="text" id="title" class="form-control" name="title" placeholder="Enter Title" required="">
                            </div>
                            <div class="form-group">
                                <label>Outside Link</label>
                                <input type="text" id="outside_link" class="form-control" name="outside_link" placeholder="Enter Outside Link">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Status<span class="required">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                            </div>
                            <input type="hidden" name="ourExpertise_id" id="ourExpertise_id">
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
            <form method="post" enctype="multipart/form-data" action="{{url('admin/our-expertise/image-update')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Image Name</label>
                        <input type="text" name="image_name" class="form-control" placeholder="Enter Image Name">
                    </div>
                    <div class="form-group">
                        <label>Image Alt</label>
                        <input type="text" name="image_alt" class="form-control" placeholder="Enter Image Alt">
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
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
        var description = $(this).data('description');
        var outside_link = $(this).data('outside_link');
        var status = $(this).data('status');
        $('#modal-edit').modal('show');
        $('#ourExpertise_id').val(id);
        $('#title').val(title);
        $('#description').val(description);
        $('#outside_link').val(outside_link);
        $('#status').val(status);
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