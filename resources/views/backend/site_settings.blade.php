@extends('backend.layout')
@section('content')
<style>
    .footer-icon {
    display: block;
    float: left;
    padding-top: 5px;
}
span.footer-desc {
    display: flex;
}
</style>
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
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('/admin/site-settings') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @foreach ($configs as $config)
                                    @if($config->key == 'dr_tv' || $config->key == 'music_awards' || $config->key == 'credit_status')
                                        <div class="form-group">
                                            <label for="{{ $config->key }} text-uppercase">{{ ucfirst(trans(str_replace('_', ' ', $config->key))) }}</label>
                                            <select name="{{ $config->key }}" id="{{ $config->key }}" class="form-control">
                                                <option value="1" {{ ($config->value == 1) ? 'selected':'' }}>Active</option>
                                                <option value="0" {{ ($config->value == 0) ? 'selected':'' }}>In Active</option>
                                            </select>
                                        </div>
                                    @elseif($config->key == 'interested_in_working')
                                    <?php continue; ?>
                                    @else
                                    <div class="form-group">
                                        <label for="{{ $config->key }} text-uppercase">{{ ucfirst(trans(str_replace('_', ' ', $config->key))) }}</label>
                                        <input type="text" name="{{ $config->key }}" id="{{ $config->key }}" class="form-control" value="{{ $config->value  }}">
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-upload"></i> Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('js')
<script>
    $("#logo").attr('type', 'file'); 
    $("#favicon").attr('type', 'file'); 
</script>
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
@endpush