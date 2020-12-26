
<?php
	$f_url = 'storage/app/public/uploads';
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{-- {{$title}} --}}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/font-awesome-animation.min.css') }}">
	<!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="{{ asset('public/backend/dist/cdn/ionicons.min.css') }}">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ asset('public/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('public/backend/dist/css/adminlte.min.css') }}">
	<!-- menu -->
	<link rel="stylesheet" href="{{ asset('public/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- toastr -->
	<link rel="stylesheet" href="{{ asset('public/backend/dist/cdn/toastr.min.css') }}">
	<!-- custom -->
	<link rel="stylesheet" href="{{ asset('public/backend/dist/css/custom.css') }}">
	  <!-- toaster-alert -->
   <link rel="stylesheet" href="{{ asset('public/backend/plugins/toaster/toastr.css')}}">
   <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap-sweetalert/dist/sweetalert.css')}}">
      <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
	<style type="text/css">
		.required{
			color: red;
			font-weight: bold;
		}
	</style>
	@yield('css')
	<!-- <style type="text/css">
	    .note-editable{
	        height: 300px !important ;
	    }
	</style> -->
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed" style="height: auto;">
	<!-- Site wrapper -->
	<div class="wrapper">
		@include('backend.include.navbar')
		@include('backend.include.main_sidebar')
		<!-- Content Wrapper. Contains page content -->
		@yield('content')
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<span><b>Version</b> 1.0 - Beta</span>
			</div>
			<strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}"> Epicmusicla</a>.</strong> All rights reserved.
		</footer>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->
	<!-- jQuery -->
	<script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('public/backend/dist/js/adminlte.min.js') }}"></script>
	<!-- menu -->
	<link rel="stylesheet" href="{{ asset('public/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
	<!-- AdminLTE for demo purposes -->

	<script src="https://unpkg.com/sweetalert2@7.33.1/dist/sweetalert2.all.js"></script>
	
	<script src="{{ asset('public/backend/dist/js/demo.js') }}"></script>
{{-- 	<!-- toastr -->
	<script src="{{ asset('public/backend/dist/cdn/toastr.min.js') }}"></script>
	{!! Toastr::message() !!} --}}
<!---alertjs file-->
   <script  src="{{ asset('public/backend/plugins/toaster/toastr.min.js')}}"></script>
    <script  src="{{ asset('public/backend/plugins/bootstrap-sweetalert/dist/sweetalert.min.js')}}"></script>
    <!-- datatable -->
<script src="{{asset('public/backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
	<script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}','Error',{
                    closeButton:true,
                    progressBar:true,

                });
            @endforeach
        @endif
    </script>
<script type="text/javascript">
    function deleteCertification(id){
        const swalWithBootstrapButtons = Swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
        })

        swalWithBootstrapButtons({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            event.preventDefault();
            document.getElementById('delete-form-'+id).submit();
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons(
              'Cancelled',
              'Your Data is safe :)',
              'error'
            )
          }
        })
    }
</script>
     <script>
     @if(Session::has('messege'))
          var type="{{Session::get('alert-type','info')}}"
          switch(type){
              case 'info':
                   toastr.info("{{ Session::get('messege') }}");
                   break;
              case 'success':
                  toastr.success("{{ Session::get('messege') }}");
                  break;
              case 'warning':
                 toastr.warning("{{ Session::get('messege') }}");
                  break;
              case 'error':
                  toastr.error("{{ Session::get('messege') }}");
                  break;
          }
        @endif
  </script>
  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@stack('js')
</body>
</html>