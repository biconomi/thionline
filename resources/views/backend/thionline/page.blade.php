@extends('backend.thionline.0_layout.master.adminlte')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">

          @yield('content-header')



        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          @yield('contents')

          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

@stop