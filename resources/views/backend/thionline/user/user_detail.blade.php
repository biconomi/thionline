@extends('backend.thionline.page')

{{--  --}}
@section('content-header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">User detail</h1>
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
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle" src="upload/avartar/{{$profile_user->img}}" alt="User profile picture" style="height: 150px;width: 150px;">
        </div>
  
        <h3 class="profile-username text-center">{{$profile_user->name}}</h3>
  
        <p class="text-muted text-center">Huynhdai Tây Đô</p>
  
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Giới tính</b> 
            <a class="float-right">
              @if($profile_user->sex==1)
              Nữ
              @else
              Nam
              @endif
            </a>
          </li>
          <li class="list-group-item">
            <b>Điện thoại</b> <a class="float-right">{{$profile_user->phone}}</a>
          </li>
          <li class="list-group-item">
            <b>Email</b> <a class="float-right">{{$profile_user->email}}</a>
          </li>
        </ul>
  
        <a href="{{route('home')}}" type="button" class="btn btn-primary btn-block"><b>Home</b></a>
        
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Thông tin về tôi</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ</strong>
  
        <p class="text-muted">{{$profile_user->address}}, {{$profile_user->wa_name}}, {{$profile_user->dis_name}}, {{$profile_user->pr_name}}.</p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <!-- /.tab-pane -->
          <div class="active tab-pane" id="settings">
            <form role="form"  onsubmit="return update();" id="frm_update_user_detail"  name="frm_update_user_detail" method="POST" action="{{route('users.detail')}}" enctype="multipart/form-data"> 
              @csrf
              <!-- input states -->
              <div class="form-group">
                <label class="col-form-label" for="inputSuccess"><i class="fas fa-mobile-alt"></i> Số điện thoại</label>
                <input type="text" id="txt_phone" name="txt_phone" class="form-control" id="inputSuccess" placeholder="Mobile Phone" maxlength="11" value={{$profile_user->phone}}>
              </div>


              <div class="form-group">
                <label class="col-form-label" for="inputSuccess"><i class="fas fa-key"></i> Mật khẩu</label>
                <input type="text" id="txt_pass" name="txt_pass" class="form-control" id="inputSuccess" placeholder="Để trống là không có đổi mật khẩu " maxlength="8" >
              </div>
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" id="txt_file" name="txt_file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" class="custom-file-input"  onchange="chang_img_create_user();">
                  <label class="custom-file-label" for="exampleInputFile"></label>
                </div>
              </div>
              <div class="col-md-12">
                <div id="img_review" class="form-group has-success">
               
                </div>
              </div>

              <button type="submit" class="btn btn-info float-right">Update</button>
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
    <!-- /.nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
@endsection






{{--  --}}
@section('custom_css')

@endsection





{{--  --}}
@section('custom_js')
<script src="plugins/sweetalert2/sweetalert2.all.js"></script>
<!-- bs-custom-file-input cusstomfile upload --> 
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


<script>

$(document).ready(function () {
  bsCustomFileInput.init();
}); 


// khong cho nhap chu vao thoi gian lam bai thi
$('#txt_phone').keypress(function()
    {
        var keyword=null;
        if(window.event)
        {
            keyword=window.event.keyCode;
        }else
        {
            keyword=e.which; //NON IE;
        }

        if(keyword<48 || keyword>57)
        {
            if(keyword==48 || keyword==127)
            {
                return ;
            }
            return false;
        }
    });

$('#frm_update_user_detail').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
});

function update()
{
  if(validate_error()==0)
  {
    return true; 
  }
  else
  {
    return false;
  }
}


function validate_error()
{
    validate=0;
    validate_success();    
    if($('#txt_phone').val()=='')
    {
      validate=1;
      $('#txt_phone').attr('class','form-control is-invalid');
    }
    else
    {
      if($('#txt_phone').val().length<10)
      {
        validate=1;
        $('#txt_phone').attr('class','form-control is-invalid');
      }
    }

    if($('#txt_pass').val()=='')
    {
    
    }
    else
    {
      if($('#txt_pass').val().length<6||$('#txt_pass').val().length>8)
      { 
        validate=1;
        $('#txt_pass').attr('class','form-control is-invalid');
      }
    }

    if(chang_img_create_user()==false)
    {
      validate =1;
      $('#txt_file').attr('class','custom-file-input is-invalid');
    }

    return validate;

}
function validate_success()
{  
    $('#txt_phone').attr('class','form-control is-valid');
    $('#txt_pass').attr('class','form-control is-valid');
    $('#txt_file').attr('class','custom-file-input is-valid');
}
function chang_img_create_user(){
	var file=document.forms["frm_update_user_detail"].elements["txt_file"].value;
      if(file.length>0)
      {
          if (window.File && window.FileReader && window.FileList && window.Blob)
          {
              // lay dung luong va kieu file tu the input file
              var fsize = $('#txt_file')[0].files[0].size;
              var ftype = $('#txt_file')[0].files[0].type;
              var fname = $('#txt_file')[0].files[0].name;      
                  switch(ftype)
                  {
                    case 'image/png':
                    case 'image/jpeg':
                    case 'image/pjpeg':                
                    break;
                    default:
                    Swal.fire('Khùng hả mậy!','kêu chọn ảnh mà!','warning');
                    $('#txt_file').val('');
                    return false;  
                  }
                  if(fsize>4048576) //thuc hien dieu gi do neu dung luong file vuot qua 4MB
                  {
                    Swal.fire("Kích thước lớn hơn 4MB","không hỗ trợ", "warning");   
                      $('#txt_file').val('');
                      return false;
                  }

                  var fileInput = document.forms["frm_update_user_detail"].elements["txt_file"];
                  if (fileInput.files && fileInput.files[0]) 
                  {
                  	var reader = new FileReader();
                  	reader.onload = function(e) { 
                  		document.getElementById('img_review').innerHTML = '<img class="wd-80 rounded-circle" style="height: 100px;width: 100px;" src="'+e.target.result+'"/>';
                  	};
                  	reader.readAsDataURL(fileInput.files[0]);
                  }
          }
          else
          {
            Swal.fire("Trình duyệt","không hỗ trợ", "warning");
            return false;   
          }
      }
      else
      {
      	 
      }
      return true;      
}
</script>

@endsection
