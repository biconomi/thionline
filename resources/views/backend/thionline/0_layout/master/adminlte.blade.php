<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <base href="{{asset('adminlte')}}/">

  <title>AdminLTE 3 | Starter</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/pace-progress/themes/black/pace-theme-flat-top.css">
    @yield('custom_css')
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed pace-primary">
  <div id="overlay">
    <div class="cv-spinner">
      <span class="spinner"></span>
    </div>
  </div>
<div class="wrapper">
  <!-- Navbar -->
  @include('backend.thionline.0_layout.include.navbar_top')
  <!-- /.navbar -->

  <!-- Main Sidebar Container menu trai-->
  @include('backend.thionline.0_layout.include.sidebar_menu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')

  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('backend.thionline.0_layout.include.aside')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('backend.thionline.0_layout.include.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
  <!-- pace-progress -->
  <script src="plugins/pace-progress/pace.min.js"></script>
{{-- tư viêt thêm --}}
<script src="js/custom.js"></script>


{{-- sinper --}}
<style>
  #overlay{	
	position: fixed;
	top: 0;
	z-index: 100;
	width: 100%;
	height:100%;
	display: none;
	background: rgba(0,0,0,0.6);
}
.cv-spinner {
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;  
}
.spinner {
	width: 40px;
	height: 40px;
	border: 4px #ddd solid;
	border-top: 4px #2e93e6 solid;
	border-radius: 50%;
	animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
	100% { 
		transform: rotate(360deg); 
	}
}
.is-hide{
	display:none;
}
</style>

<script>

$(document).ready(function(){

	// Binds to the global ajax scope
	$( document ).ajaxStart(function() {	
		$("#overlay").fadeIn(300);　
	});

	$( document ).ajaxComplete(function() {	
		$("#overlay").fadeOut(300);
	});
});
</script>

@yield('custom_js')
</body>
</html>
