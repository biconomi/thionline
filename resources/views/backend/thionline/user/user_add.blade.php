@extends('backend.thionline.page')

{{--  --}}
@section('content-header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Thêm người dùng</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">add</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->

@endsection
{{-- Noi dung web --}}
@section('contents')
@if(Session::has('message'))  
<script src="plugins/sweetalert2/sweetalert2.all.js"></script>
<script>
  {{ Session::get('message')}}
  @if(Session::get('message')=='true')
          Swal.fire({
            title: 'Đang thêm người dùng mới',
            html: 'Vui lòng chờ',
            timer: 2000,
            timerProgressBar: true,
            onBeforeOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                  const b = content.querySelector('b')
                  if (b) {
                    b.textContent = Swal.getTimerLeft()
                  }
                }
              }, 100)
            },
            onClose: () => {
              clearInterval(timerInterval)
              window.location="{{route('users.add')}}";
            }
          })
  @else
      Swal.fire({
      icon: 'error',
      title: 'Không thêm được',
      text: 'Có lẽ email đã trùng!'
    })
  @endif
</script>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Thêm người dùng</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <form role="form" id="frmCreateUser"  onsubmit="return add();" name="frmCreateUser" method="POST" action="{{route('users.store')}}" enctype="multipart/form-data"> 
              @csrf
              <div class="row">
                <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                    <label class="col-form-label" for="inputSuccess"><i class="fas fa-user"></i> Họ tên</label>
                    <input type="text" class="form-control" id="txt_name" name ="txt_name"  placeholder="Full name" maxlength="40">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="inputSuccess"><i class="fas fa-female"></i> Giới tính</label>
                    <select class="select2" id="txt_sex" name ="txt_sex" data-placeholder="sex" style="width: 100%;">
                        <option value='0'>Nam</option>
                        <option value='1'>Nữ</option>
                    </select> 
                  </div>
                </div>
              </div>

              <!-- input states -->
              <div class="form-group">
                <label class="col-form-label" for="inputSuccess"><i class="fas fa-mobile-alt"></i> Số điện thoại</label>
                <input type="text" id="txt_phone" name="txt_phone" class="form-control" id="inputSuccess" placeholder="Mobile Phone" maxlength="11">
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputSuccess"><i class="fas fa-envelope-open-text"></i> Email</label>
                <input type="text" id="email" name="email" class="form-control" id="inputSuccess" placeholder="email" maxlength="30" onchange="check_email()">
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputSuccess"><i class="fas fa-map-marker-alt"></i> Địa chỉ nhà</label>
                <input type="text" id="txt_address" name="txt_address" class="form-control" id="inputSuccess" placeholder="Address" maxlength="30">
              </div>
              <div class="form-group">
                <label class="col-form-label" for="inputSuccess"><i class="fas fa-key"></i> Mật khẩu</label>
                <input type="text" id="txt_pass" name="txt_pass" class="form-control" id="inputSuccess" placeholder="Dài hơn 6 kí tụ và nhỏ hơn 8" maxlength="8" >
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <!-- select -->
                  <div class="form-group">
                    <label class="col-form-label" for="inputSuccess"><i class="fas fa-city"></i> Tỉnh</label>
                    <select class="select2" id="txt_provinces" name ="txt_provinces" data-placeholder="Chọn tỉnh" style="width: 100%;">
                          @foreach($provinces as $pr)
                              <option value='{{$pr->pr_id}}' {{$pr->pr_id==95?'selected="selected"':''}}>{{$pr->pr_name}}</option>
                          @endforeach
                    </select> 
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="inputSuccess"><i class="fas fa-building"></i> Huyện</label>
                    <select class="select2" id="txt_district" name ="txt_district" data-placeholder="Chọn huyện" style="width: 100%;">
                    </select> 
                  </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                      <label class="col-form-label" for="inputSuccess"><i class="fas fa-home"></i>Xã</label>
                      <select class="select2" id="txt_wards" name ="txt_wards" data-placeholder="Chọn xã phường" style="width: 100%;">

                      </select> 
                    </div>
                  </div>

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

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button id="btnsave"  type="submit" class="btn btn-info">Thêm</button>
            <button type="button" class="btn btn-default float-right">Cancel</button>
          </div>
        </form>
        </div>
    </div>
</div>
@endsection


{{--  --}}
@section('custom_css')
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

@endsection

{{--  --}}
@section('custom_js')
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>

<script src="plugins/sweetalert2/sweetalert2.all.js"></script>
<!-- bs-custom-file-input cusstomfile upload --> 
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>  
$(document).ready(function () {
  bsCustomFileInput.init();
});  
$(function () {
//Initialize Select2 Elements
    $('.select2').select2()
})
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
$('#frmCreateUser').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
});

function add()
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
var validate=0;
function validate_error()
{
    validate=0;
    validate_success();
    if($('#txt_name').val()=='')
    {
      $('#txt_name').attr('class','form-control is-invalid');
      validate=1;
    }
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

    if($('#email').val()=='')
    {
      validate =1;
      $('#email').attr('class','form-control is-invalid');
    }
    else
    {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (reg.test($('#email').val()) == false) 
        {
          validate =1;
          $('#email').attr('class','form-control is-invalid');
        }
        else
        {
          check_email();
        }
    }
    
    if($('#txt_address').val()=='')
    {
      validate=1;
      $('#txt_address').attr('class','form-control is-invalid');
    }
    if($('#txt_pass').val()=='')
    {
      validate=1;
      $('#txt_pass').attr('class','form-control is-invalid');
    }
    else
    {
      if($('#txt_pass').val().length<6||$('#txt_pass').val().length>8)
      { 
        validate=1;
        $('#txt_pass').attr('class','form-control is-invalid');
      }
    }
    
    if($('#txt_provinces').val()==null||$('#txt_district').val()==null||$('#txt_wards').val()==null)
    {
      validate=1;
      Swal.fire("Error","Kiểm tra lại địa chỉ", "warning");
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
    $('#txt_name').attr('class','form-control is-valid');
    $('#txt_phone').attr('class','form-control is-valid');
    $('#email').attr('class','form-control is-valid');
    $('#txt_address').attr('class','form-control is-valid');
    $('#txt_pass').attr('class','form-control is-valid');

    $('#txt_file').attr('class','custom-file-input is-valid');
    $('#error_email').remove();
}

function chang_img_create_user(){
	var file=document.forms["frmCreateUser"].elements["txt_file"].value;
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

                  var fileInput = document.forms["frmCreateUser"].elements["txt_file"];
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
      	 return false;
      }      
}

function check_email()
{
  var _token=document.forms['frmCreateUser'].elements["_token"].value;
    var hadding='checkemail'
      var url='{{route('users.hadding')}}';//url chuyen huong xu ly usercontroller
      $.ajax({
        headers: { 'X-CSRF-TOKEN': _token},
        url: url,
        data: {hadding:hadding,email:$('#email').val()},
        type: 'Post',
        cache:false,      
        success:function(data)
        {
          if(data=='1')
          {
            validate=1;
            $('#email').attr('class','form-control is-invalid');
            $('#email').after('<p id="error_email" style="color:red;">Đã tồn tại</>')
          }
          else
          {
            validate=0;
          }
        },
        error: function (jqXHR,xhr, ajaxOptions, thrownError) {
          Swal.fire("Error","Thất bại", "warning");
        }

      });
}


$('#txt_provinces').change(function(){
  onchang_tinh();
  $('#txt_wards').empty();
});

$('#txt_district').change(function(){
  onchange_huyen();
});


function onchang_tinh()
{
  var _token=document.forms['frmCreateUser'].elements["_token"].value;
    var hadding='onchang_tinh'
      var url='{{route('users.hadding')}}';//url chuyen huong xu ly usercontroller
      $.ajax({
        headers: { 'X-CSRF-TOKEN': _token},
        url: url,
        data: {hadding:hadding,id_province:$('#txt_provinces').val()},
        type: 'Post',
        cache:false,      
        success:function(data)
        {
          $('#txt_district').empty();
          $txt_district='';
            $.each(data, function(i, item) {
              if(i==0)
              {
                $txt_district=$txt_district + '<option selected="selected" value="'+item.id_dis+'">'+item.dis_name+'</option>'
              }
              else
              {
                $txt_district=$txt_district + '<option value="'+item.id_dis+'">'+item.dis_name+'</option>'
              }

            });
          $('#txt_district').append($txt_district);
        },
        error: function (jqXHR,xhr, ajaxOptions, thrownError) {
          Swal.fire("Error","Thất bại", "warning");
        }

      });
}
function onchange_huyen()
{
  var _token=document.forms['frmCreateUser'].elements["_token"].value;
    var hadding='onchang_huyen'
      var url='{{route('users.hadding')}}';//url chuyen huong xu ly usercontroller
      $.ajax({
        headers: { 'X-CSRF-TOKEN': _token},
        url: url,
        data: {hadding:hadding,id_district:$('#txt_district').val()},
        type: 'Post',
        cache:false,      
        success:function(data)
        {
          $('#txt_wards').empty();
          $txt_wards='';
            $.each(data, function(i, item) {
              if(i==0)
              {
                $txt_wards=$txt_wards + '<option selected="selected" value="'+item.wa_id+'">'+item.wa_name+'</option>'
              }
              else
              {
                $txt_wards=$txt_wards + '<option value="'+item.wa_id+'">'+item.wa_name+'</option>'
              }

            });
          $('#txt_wards').append($txt_wards);
        },
        error: function (jqXHR,xhr, ajaxOptions, thrownError) {
          // Swal.fire("Error","Thất bại", "warning");
        }

      });
}
</script>
@endsection
