@extends('backend.thionline.page')

{{--  --}}
@section('content-header')

<div class="row mb-2" id="div_header">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Exam</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">Exam</li>
    
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->

@endsection
{{-- Noi dung web --}}
@section('contents')
<div class="row" id="div_question">
    @foreach($exam as $ex)
    <div class="col-md-4">
    <form action="post" id="frm_exam{{$ex->id_exam}}" name="frm_exam{{$ex->id_exam}}">
        @csrf
        <!-- general form elements -->
        <div class="card card-secondary">
          <div class="card-header">   
            <h3 class="card-title">[{{$ex->id_exam}}] &nbsp&nbsp&nbsp&nbsp</h3>      
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <i style="color:#28a745; font-size:18pt!important;"  class="far fa-check-square"></i> &nbsp&nbsp &nbsp &nbsp Đề thi: <a class="float-right">{{strtoupper($ex->name)}} </a>
                  </li>
                    <li class="list-group-item">
                      <i style="color:#28a745; font-size:18pt!important;"  class="far fa-check-square"></i> &nbsp&nbsp &nbsp &nbsp Số lượng câu hỏi:<a class="float-right">[{{$ex->number_question}}]</a>
                    </li>
                    <li class="list-group-item">
                      <i style="color:#28a745; font-size:18pt!important;"  class="far fa-check-square"></i> &nbsp&nbsp &nbsp &nbsp Thời gian thi:<a class="float-right">{{$ex->time_test}} phút</a>
                    </li>
                    <li class="list-group-item">
                      <i style="color:#28a745; font-size:18pt!important;"  class="far fa-check-square"></i> &nbsp&nbsp &nbsp &nbsp Ngày thi:<a class="float-right">{{\Carbon\Carbon::parse($ex->date_begin)->format('d-m-Y')}}</a>
                    </li>
                    <li class="list-group-item">
                      <i style="color:#28a745; font-size:18pt!important;"  class="far fa-check-square"></i> &nbsp&nbsp &nbsp &nbsp Ghi chú<a class="float-right">{{$ex->description}} </a>
                  </li>
                  </ul>
                <button onclick="load_exam_test('frm_exam{{$ex->id_exam}}','{{$ex->id_exam}}');" type="button" class="btn btn-secondary btn-block"> <i style="color:red; font-size:18pt!important;" class="fas fa-skull-crossbones"></i>&nbsp&nbsp &nbsp &nbsp<b>Bắt đầu thi</b></button>
            </div>
            
            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.card -->
      </form> 
    </div>
    @endforeach

</div>

<div id="div_test">
</div>
@endsection


{{--  --}}
@section('custom_css')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection

{{--  --}}
@section('custom_js')
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
<script src="plugins/sweetalert2/sweetalert2.all.js"></script>
<script src="plugins/exam/jquery.countdown.js"></script>

{{-- ---------------------------------------------------------------------- --}}
<script>
//load chi tiet de thi

function load_exam_test(frm,id_exam)
{   
    var _token=document.forms[frm].elements["_token"].value;
		// var form_data = new FormData(document.forms.frm_exam+frm);
    //form_data.append('id_topic', id_topic);
		var url='{{route('exam.choose_test_ajax')}}';
		$.ajax({
			headers: { 'X-CSRF-TOKEN': _token},
			url: url,
			data: {id:id_exam},
			type: 'Post',
			cache:false,      
			success:function(data)
			{
        if(data=='-1')
        {
          Swal.fire("Error","Bạn đang thi một để khác", "warning");
        }
        else
        {
          if(data=='-2')
          {
            Swal.fire("Error","Bạn đang bị khóa", "warning"); 
          }
          else
          {
            if(data=='thiroi')
            {
              Swal.fire("Error","Bạn đã thi đề này rồi", "warning");
            }
            else
            {
              $('#div_test').append(data);
              $('#div_question').empty();
              $('#div_header').empty(); 
            }

          }
        }
       

			},
			error: function (jqXHR,xhr, ajaxOptions, thrownError) {
        Swal.fire("Error","Thất bại", "warning");
			}

		});
}
//get cau tra loi

function get_option_user()
{

}


function validate_sucsess()
{

}
function valida_error()
{

}
function btn_nopbai(id_exam)
{
  ajax_nopbai(id_exam);
}
function ajax_nopbai(id_exam)
{
    var _token=document.forms["nopbai"].elements["_token"].value;
    var form_data = new FormData(document.forms.nopbai);
    chuanhoa();
    form_data.append('id_option','['+phantach+']');   // add haading xu ly ben controller
    form_data.append('id_result_exam',id_exam);   // add haading xu ly ben controller
    var url='{{route('exam.choose_test_submit')}}';
		$.ajax({
			headers: { 'X-CSRF-TOKEN': _token},
			url: url,
			data: form_data,
			type: 'Post',
			contentType: false,
			processData: false,
			cache:false,   
			success:function(data)
			{           
        $('#result_tesst').append(data);
        Swal.fire('Thành công!','Chúc bạn mai mắn!','success');
        hidden_test_datail();
			},
			error: function (jqXHR,xhr, ajaxOptions, thrownError) {
        Swal.fire("Error","Thất bại", "warning");
			}
		});
}
</script>
@endsection
