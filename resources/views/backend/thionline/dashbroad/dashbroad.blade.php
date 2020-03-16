@extends('backend.thionline.page')

{{--  --}}
@section('content-header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Dashbroad</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">Starter Page</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->

@endsection



{{-- Noi dung web --}}
@section('contents')

<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>150</h3>

        <p>New Orders</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>53<sup style="font-size: 20px">%</sup></h3>

        <p>Bounce Rate</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>44</h3>

        <p>User Registrations</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>65</h3>

        <p>Unique Visitors</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-md-5">
    <div class="card">
      <!-- /.card-header -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="https://placehold.it/900x500/39CCCC/ffffff&amp;text=I+Love+Bootstrap" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="https://placehold.it/900x500/3c8dbc/ffffff&amp;text=I+Love+Bootstrap" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="https://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Recently Added Products</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <ul class="products-list product-list-in-card pl-2 pr-2">
        <li class="item">
          <div class="product-img">
            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
          </div>
          <div class="product-info">
            <a href="javascript:void(0)" class="product-title">Samsung TV
              <span class="badge badge-warning float-right">$1800</span></a>
            <span class="product-description">
              Samsung 32" 1080p 60Hz LED Smart HDTV.
            </span>
          </div>
        </li>
        <!-- /.item -->
        <li class="item">
          <div class="product-img">
            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
          </div>
          <div class="product-info">
            <a href="javascript:void(0)" class="product-title">Bicycle
              <span class="badge badge-info float-right">$700</span></a>
            <span class="product-description">
              26" Mongoose Dolomite Men's 7-speed, Navy Blue.
            </span>
          </div>
        </li>
        <!-- /.item -->
        <li class="item">
          <div class="product-img">
            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
          </div>
          <div class="product-info">
            <a href="javascript:void(0)" class="product-title">
              Xbox One <span class="badge badge-danger float-right">
              $350
            </span>
            </a>
            <span class="product-description">
              Xbox One Console Bundle with Halo Master Chief Collection.
            </span>
          </div>
        </li>
        <!-- /.item -->
        <li class="item">
          <div class="product-img">
            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
          </div>
          <div class="product-info">
            <a href="javascript:void(0)" class="product-title">PlayStation 4
              <span class="badge badge-success float-right">$399</span></a>
            <span class="product-description">
              PlayStation 4 500GB Console (PS4)
            </span>
          </div>
        </li>
        <!-- /.item -->
      </ul>
    </div>
    <!-- /.card-body -->
    <div class="card-footer text-center">
      <a href="javascript:void(0)" class="uppercase">View All Products</a>
    </div>
    <!-- /.card-footer -->
  </div>
</div>
</div>

@endsection






{{--  --}}
@section('custom_css')
  <!-- Ionicons font bieu tuong cho dashbroad -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endsection





{{--  --}}
@section('custom_js')

@endsection
