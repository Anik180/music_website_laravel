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

                <div class="card-tools">
                  <div class="input-group input-group-sm">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add {{$title}} <i class="fa fa-plus"></i></button>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Url</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($about_us as $key=>$list)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{($list->title) ? $list->title :'Null'}}</td>
                      <td>{{($list->url) ? $list->url :'Null'}}</td>
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
                        <a class="btn btn-primary waves-effect btn-sm" id="item_edit" href="javascript:void(0);"  
                                data-id="<?php echo $list->id; ?>" 
                                data-title="<?php echo $list->title; ?>"  
                                data-url="<?php echo $list->url; ?>"  
                                data-description="<?php echo $list->description; ?>"  
                                data-status="<?php echo $list->status; ?>"  
                            >
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger waves-effect btn-sm" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                        <form id="delete-form-{{$list->id}}" action="{{route('aboutUs.destroy',$list->id)}}" method="post" style="display: none;">
                        @method('delete')
                        @csrf
                           
                        </form>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div align="center">
                    {!! $about_us->links() !!} 
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
            <form method="POST" accept="{{url('admin/aboutUs')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title<span class="required">*</span>/label>
                        <input type="text" class="form-control" name="title" required="" placeholder="Enter Title">
                    </div>

                    <div class="form-group">
                        <label>Url<span class="required">*</span></label>
                        <input type="text" class="form-control" name="url" required="" placeholder="Enter Url">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4" placeholder="Enter Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <!-- Add Modal -->

    <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Update {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{url('admin/aboutUs/update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                        <div class="form-group">
                            <label>Title<span class="required">*</span></label>
                            <input type="text" id="title" class="form-control" name="title" required="" placeholder="Enter Title">
                        </div>

                        <div class="form-group">
                            <label>Url<span class="required">*</span></label>
                            <input type="text" id="url" class="form-control" name="url" required="" placeholder="Enter Url">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Description"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status<span class="required">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="2">In Active</option>
                            </select>
                        </div>
                        <input type="hidden" name="aboutUs_id" id="aboutUs_id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('table').on('click','#item_edit',function(){
            var id = $(this).data('id');
            var title = $(this).data('title');
            var url = $(this).data('url');
            var description = $(this).data('description');
            var status = $(this).data('status');
            $('#modal-edit').modal('show');
            $('#aboutUs_id').val(id);
            $('#title').val(title);
            $('#url').val(url);
            $('#description').val(description);
            $('#status').val(status);
        });
    })
</script>
@endpush