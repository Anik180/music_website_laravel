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
                      <th>ID</th>
                      <th>Title 1</th>
                      <th>Title 2</th>
                      <th>Title 3</th>
                      <th>Status</th>
                      <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $key=>$list)
                <tr>
                         <td>{{$key+1}}</td>
                      <td>{{($list->title_1) ? $list->title_1 :'Null'}}</td>
                      <td>{{($list->title_2) ? $list->title_2 :'Null'}}</td>
                      <td>{{($list->title_3) ? $list->title_3 :'Null'}}</td>
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
                        <a class="btn btn-info waves-effect btn-md" id="item_edit" href="javascript:void(0);"  
                                data-id="<?php echo $list->id; ?>" 
                                data-title_1="<?php echo $list->title_1; ?>"  
                                data-title_2="<?php echo $list->title_2; ?>"  
                                data-title_3="<?php echo $list->title_3; ?>"  
                                data-video="<?php echo $list->video; ?>"  
                                data-description="<?php echo $list->description; ?>"  
                                data-video_link="<?php echo $list->video_link; ?>"  
                                data-youtube_video_link="<?php echo $list->youtube_video_link; ?>"  
                                data-status="<?php echo $list->status; ?>"  
                            >
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-danger waves-effect btn-md" onclick="return deleteCertification(<?php echo $list->id; ?>)"><i class="fa fa-trash"></i></button>
                        <form id="delete-form-{{$list->id}}" action="{{route('slider.destroy',$list->id)}}" method="post" style="display: none;">
                        @method('delete')
                        @csrf
                           
                        </form>
                    </td>
                </tr>
               @endforeach
                </tbody>
                <tfoot>
                <tr>
                      <th>ID</th>
                      <th>Title 1</th>
                      <th>Title 2</th>
                      <th>Title 3</th>
                      <th>Status</th>
                      <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
       {{--     <div align="center">
                    {!! $sliders->links() !!} 
                </div>
            <!-- /.card --}}
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
            <form method="POST" accept="{{url('admin/slider')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title 1</label>
                        <input type="text" class="form-control" name="title_1" placeholder="Enter Title 1 (Optional)">
                    </div>

                    <div class="form-group">
                        <label>Title 2</label>
                        <input type="text" class="form-control" name="title_2" placeholder="Enter Title 2 (Optional)">
                    </div>

                    <div class="form-group">
                        <label>Title 3</label>
                        <input type="text" class="form-control" name="title_3" placeholder="Enter Title 3 (Optional)">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4" placeholder="Enter Description (Optional)"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Video Link</label>
                        <input type="text" class="form-control" name="video_link" placeholder="Video Link (Optional)">
                    </div>
                    <div class="form-group">
                        <label>YouTube Video Link</label>
                        <input type="text" class="form-control" name="youtube_video_link" placeholder="youtube Video Link (Optional)">
                    </div>
                    <div class="form-group">
                        <label>Video</label>
                        <input type="file" class="form-control" name="video">
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

    <div id="modal-edit" class="modal fade bs-example-modal-center" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Update {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('admin/slider/update')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title 1 (Optional)</label>
                        <input type="text" id="title_1" class="form-control" name="title_1">
                    </div>

                    <div class="form-group">
                        <label>Title 2 (Optional)</label>
                        <input type="text" id="title_2" class="form-control" name="title_2">
                    </div>

                    <div class="form-group">
                        <label>Title 3 (Optional)</label>
                        <input type="text" id="title_3" class="form-control" name="title_3">
                    </div>

                    <div class="form-group">
                        <label>Video Link</label>
                        <input type="text" class="form-control" id="video_link" name="video_link" placeholder="Video Link">
                    </div>

                    <div class="form-group">
                        <label>YouTube Video Link</label>
                        <input type="text" class="form-control" id="youtube_video_link" name="youtube_video_link" placeholder="youtube Video Link (Optional)">
                    </div>

                    <div class="form-group">
                        <label>Video</label>
                        <input type="file" class="form-control" name="video">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="2">In Active</option>
                        </select>
                    </div>
                    <input type="hidden" name="slider_id" id="slider_id">
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
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('table').on('click','#item_edit',function(){
            var id = $(this).data('id');
            var title_1 = $(this).data('title_1');
            var title_2 = $(this).data('title_2');
            var title_3 = $(this).data('title_3');
            var video = $(this).data('video');
            var video_link = $(this).data('video_link');
            var youtube_video_link = $(this).data('youtube_video_link');
            var description = $(this).data('description');
            var status = $(this).data('status');
            $('#modal-edit').modal('show');
            $('#slider_id').val(id);
            $('#title_1').val(title_1);
            $('#title_2').val(title_2);
            $('#title_3').val(title_3);
            $('#description').val(description);
            $('#video_link').val(video_link);
            $('#youtube_video_link').val(youtube_video_link);
            $('#status').val(status);
        });
    })
</script>
@endpush