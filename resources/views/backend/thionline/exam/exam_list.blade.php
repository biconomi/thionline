@extends('backend.thionline.page')
{{--  --}}
@section('content-header')
@csrf
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Exam list</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">Danh sách đề thi</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->  

@endsection
{{-- Noi dung web --}}
@section('contents')

<div class="row">
  {{-- danh sach de thi --}}
  <div class="col-12" id='div_exam_'>
    @include('backend.thionline.exam.exam_add')    
    <div class="card" id="exam_list">
      
      @if(Laratrust::can('exam_btn_add'))
      <div class="card-header">
        <button id="btn_load_form_add_exam" type="button" class="btn btn-primary">Add</button>
      </div>   
      @endif   
      <div class="card-body">
        <table class="display responsive" id="list_exam" style="width:100%">
          <thead>
            @if(Laratrust::can('exam_list_admin'))
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Number</th>
                <th>Time_test</th>     
                <th>Satus</th>
                <th>Type</th>
                <th>Create</th>
                <th>Action</th>
              </tr>
            @endif
            @if(Laratrust::can('exam_list_user'))
                <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Number question</th>
                  <th>Number true</th>
                  <th>Time_test</th>     
                  <th>Satus</th>
                  <th>Test</th>
                  <th>Action</th>
                </tr>
            @endif
          </thead>
        </table>
        <div id="paginationListExam" style="margin-bottom: 10px; display: flex;">
          <input class="form-control" type="text" placeholder="Page" id="inputPaginationListUsers" style="width: 60px; margin-right: 5px;">
          <button class="btn btn-primary" id="buttonPaginationListExam">Go</button>
        </div>
      </div>
    </div>

  </div>
  {{-- bang tong hop ket qua cua 1 de thi--}}
  <div class="col-12" id="div_exam_user">

    <!-- /.card -->
  </div>
</div>

@endsection


{{--  --}}
@section('custom_css')
  <!-- Ionicons font bieu tuong cho dashbroad -->   
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"> 

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

@endsection

{{--  --}}
@section('custom_js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script src="plugins/sweetalert2/sweetalert2.all.js"></script> --}}
<script type='text/javascript' src='https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js'></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask  thoi gian --> 
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
{{-- ---------------------------------------------------------------------- --}}
<script>
  window.onload = function()
	{
    $('#create_exam')[0].reset();
    //set lua chon loai cau hoi tu dong
    check_type();
  };


	$( document ).ajaxComplete(function() {	
		check_id_question_to_datatable();
	});

    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
    //Datemask dd/mm/yyyy
    //$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    $('[data-mask]').inputmask();

function validate_success()
{
  $('#txt_nam_exam').attr('class','form-control is-valid');  
  $('#error_txttopic').empty();
  $('#txt_number').attr('class','form-control is-valid'); 
  $('#txt_time_exam').attr('class','form-control is-valid');  
  $('#date_start').attr('class','form-control is-valid');  
  $('#txt_content').attr('class','form-control is-valid');  
}
var validateadd=0;
function validate_error()
{
  validateadd=0;
  validate_success();
  if($.trim($('#txt_nam_exam').val())=='')
  {
    $('#txt_nam_exam').attr('class','form-control is-invalid');  
    validateadd=1;
  }
  if($.trim($("#txttopic").val())=='')
  {
    $('#error_txttopic').append('<p id="" style="color:red;" class="">Vui lòng chọn chủ đề</p>');   
    validateadd=1;
  }

  if($.trim($('#txt_number').val())=='')
  {
    $('#txt_number').attr('class','form-control is-invalid');  
    validateadd=1;
  }
  if($.trim($('#date_start').val())=='')
  {
    $('#date_start').attr('class','form-control is-invalid');  
    validateadd=1;
  }
  else
  {
    var date_start=$('#date_start').val();
    var year=date_start.substring(0,4); 
    var month=date_start.substring(5,7); 
    var day=date_start.substring(8,10); 

    if( isNaN(year)||isNaN(month)||isNaN(day))
    {
      $('#date_start').attr('class','form-control is-invalid');  
      validateadd=1;
    }

    else
    {
      if( year<{{\Carbon\Carbon::now()->year}} || month<{{\Carbon\Carbon::now()->month}}|| day<{{\Carbon\Carbon::now()->day}})
      {
        $('#date_start').attr('class','form-control is-invalid');  
        validateadd=1;
      }
    }  
    
  }
  if($.trim($('#txt_time_exam').val())=='')
  {
    $('#txt_time_exam').attr('class','form-control is-invalid');  
    validateadd=1;
  }
  if($.trim($('#txt_content').val())=='')
  {
    $('#txt_content').attr('class','form-control is-invalid');  
    validateadd=1;
  }
  return validateadd;
}


//Them de thi.
function exam_add()
{
  if(validate_error()==0)
  {
    add_exam();
  }
  else
  {
    alert('lổii');
  }
}
function add_exam()//them de thi 
{
    var _token=document.forms["create_exam"].elements["_token"].value;
		var form_data = new FormData(document.forms.create_exam);
    var id_topic =$("#txttopic").val();

    form_data.append('id_topic', id_topic);
		form_data.append('handling', 'create');   // add haading xu ly ben controller

        if ($('input[name=radio_question]:checked').val() == '2') 
        {             
            //chọn bằng tay
            //id_question=[];
            form_data.append('id_question', id_question);   // add haading xu ly ben controller
        }

		var url='{{route('question.topic.handling_ajax_create')}}';
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
        // alert(data);
        if(data=='-1')
				{ 
            swal("Thêm mới thất bại","Câu hỏi không đủ", "warning");
				}
        if(data=='true')
        {
          swal("Thành công","Đã tạo đề thi mới", "success");
        }
			},
			error: function (jqXHR,xhr, ajaxOptions, thrownError) {
        swal("Thêm mới","Thất bại", "warning"); 
			}

		});
}
// khong cho nhap chu vao thoi gian lam bai thi
$('#txt_time_exam').keypress(function()
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

$('#txt_number').keypress(function()
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
// lua chon cách de chọn cau hoi
$('input[type=radio][name=radio_question]').change(function () {
    if (this.value == '1') {//chọn tu động
      $('#div_input_select_question').empty();
    }
    else if (this.value == '2') {   //chọn bằng tay
      check_type();
    }
});

//add cau hoi 
function add_question()
{
  $('#div_input_select_question').empty();
      $('#div_input_select_question').append(''
       +'<table class="display responsive" id="list_question" style="width:100%">'+
              '<thead>'+
                  '<tr>'+
                    '<th>Chọn</th>'+
                    '<th>Câu hỏi</th>'+
                    '<th>Mã câu hỏi</th>'+
                    '<th>Chủ đề</th>'  +   
                    '<th>Ngày tạo</th>'  +   
                  '</tr>'+
              '</thead>'+
            '</table>'+
            '<div id="paginationlist_question" style="margin-bottom: 10px; display: flex;">'+
              '<input class="form-control" type="text" placeholder="Page" id="inputPaginationlist_question" style="width: 60px; margin-right: 5px;">'+
              '<button type="button" onclick="load_trang_cau_hoi_theo_chu_de();" class="btn btn-primary" id="buttonPaginationlist_question">Go</button>'+
            '</div>');      
      load_question_topic();//load danh sach de thi theo chu de  
}

// tao mang de luu id chọn cau hoi khi chọn bằng tay
var id_question=[];
function select_id_question(id)
{
    // alert(id);
    var checked = $("#checkboxSuccess"+id+":checked").length;
    //alert(checked);
    if (checked == 0) {
        for (var i=0;  i < id_question.length;i++) 
        {
          if (id_question[i] === $("#checkboxSuccess"+id).val()) {
            id_question.splice(i,1);
            break;
          }
        }
    } else {
      id_question.push($("#checkboxSuccess"+id).val());
    }
}
// check id cau da dong chon vao datatable
function check_id_question_to_datatable()
{
  for(var i=0;i<id_question.length;i++)
  {
    if(id_question[i]!=0)
    {
      $('#checkboxSuccess'+id_question[i]).attr('checked','');
    }
  }
}

$('#txttopic').change(function(){
  $('#div_input_select_question').empty();
  check_type();
});



function check_type ()//kiem tra lua chon va load
{
  validate_error();
  if ($('input[name=radio_question]:checked').val() == '1') 
    {   //chọn bằng tay
      $('#div_input_select_question').empty();
    }
  if ($('input[name=radio_question]:checked').val() == '2') 
  { 
      //chọn bằng tay
    id_question=[];
    var id_topic =$("#txttopic").val();    
    if(id_topic!=0)
    {
      add_question();
    }

  }


}
// ///////////////////////////////////////////////////////////////////////////////////////////////////
// load danh sách câu hoi theo chu đề cho việc tạo câu hỏi.
var page_question_topic;
function load_question_topic()//load danh sach cau hoi theo chu de
{
    var id_topic =$("#txttopic").val();
  page_question_topic= $('#list_question').DataTable({
        "scrollY": false,
        "scrollX": true,
        "lengthMenu": [[7,10, 25, 50,100], [7,10, 25, 50,100]],

        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('question.topic.handling_ajax') !!}',
            type: 'get',
            data: {id_topic: id_topic}
        },
        columns: [
                { data: 'check_box', name: 'check_box' },
                { data: 'content', name: 'question.content' },
                { data: 'id_question', name: 'question.id_question' }, 
                { data: 'name', name: 'topic.name' },
                { data: 'created_at', name: 'question.created_at' },
                
        ]
    });
}
// load trang
function load_trang_cau_hoi_theo_chu_de()
{
  var inputPage = parseInt($('#inputPaginationlist_question').val());
      var totalPages = page_question_topic.page.info().pages;
      if (!inputPage) {
        swal("Khùng hả mậy","Nhập số trang", "warning");
        $('#inputPaginationlist_question').each(function(){
          $(this).val('');
        });       
        page_question_topic.off();
      } else       
      if(inputPage>0)
      {

          if (inputPage > totalPages) {
            swal("Khùng hả mậy","Không có trang này", "warning");
            $('#inputPaginationlist_question').each(function(){
              $(this).val('');
            }); 
          } else {
            page_question_topic.page(inputPage - 1).draw(false);
          }

      }
      else
      {
        swal("Khùng hả mậy","Làm gì có trang âm", "warning");
        $('#inputPaginationlist_question').each(function(){
          $(this).val('');          
        });       
        
        
        page_customer.off();
      }
}

// load danh sach de thi
var page_customer;
$(function() {
  page_customer= $('#list_exam').DataTable({
      dom: 'Bfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            {
                extend: 'print',
                text: 'Print all (not just selected)',
                exportOptions: {
                    modifier: {
                        selected: null
                    }
                }
            }
        ],
        select: true,
        "scrollY": false,
        "scrollX": true,
        "lengthMenu": [[7,10, 25, 50,100], [7,10, 25, 50,100]],

        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '{!! route('exam.handling_ajax_exam') !!}',
        columns: [
              @if(Laratrust::can('exam_list_admin'))
                { data: 'id_exam', name: 'exam.id_exam' },
                { data: 'name', name: 'exam.name' },
                { data: 'number_question', name: 'exam.number_question' },
                { data: 'time_test', name: 'exam.time_test' },
                { data: 'status', name: 'exam.status' },                
                { data: 'type', name: 'exam.type' },
                { data: 'created_at', name: 'exam.created_at' },
                { data: 'action', name: 'action'}  
              @endif
            
              @if(Laratrust::can('exam_list_user'))
              { data: 'id_exam', name: 'exam.id_exam' },
                { data: 'name', name: 'exam.name' },
                { data: 'number_question', name: 'exam.number_question' },
                { data: 'number_true', name: 'result_exam.number_true' },
                { data: 'time_test', name: 'exam.time_test' },
                { data: 'status', name: 'exam.status' },                
                { data: 'created_at', name: 'result_exam.created_at' },
                { data: 'action', name: 'action'}                                                 
               @endif

        ]
    });
});
// phan trang de thi thi
$('#buttonPaginationListExam').click(function () {
      var inputPage = parseInt($('#inputPaginationListUsers').val());
      var totalPages = page_customer.page.info().pages;
      if (!inputPage) {
        swal("Khùng hả mậy","Nhập số trang", "warning");
        $('#inputPaginationListUsers').each(function(){
          $(this).val('');
        });       
        page_customer.off();
      } else       
      if(inputPage>0)
      {

          if (inputPage > totalPages) {
            swal("Khùng hả mậy","Không có trang này", "warning");
            $('#inputPaginationListUsers').each(function(){
              $(this).val('');
            }); 
          } else {
            page_customer.page(inputPage - 1).draw(false);
          }

      }
      else
      {
        swal("Khùng hả mậy","Làm gì có trang âm", "warning");
        $('#inputPaginationListUsers').each(function(){
          $(this).val('');          
        });  
        page_customer.off();
      }
    });


@if(Laratrust::can('exam_btn_add'))
$('#btn_load_form_add_exam').click(function()
{
    $("#frm_add_exam").toggle(1500);
    $("#exam_list").hide(1000);
});
@endif

$('#btn_cancel_form_add_exam').click(function(){
  $("#frm_add_exam").toggle(1000);
  $("#exam_list").show(1500);
});


@if(Laratrust::can('exam_list_admin'))//admin xem moi cho pheps
function exam_user(id_exam)
{
    var _token= $("input[name=_token]").val();
      var hadding='load_exam_user'
        var url='{{route('exam.haddings')}}';//url chuyen huong xu ly usercontroller
        $.ajax({
          headers: { 'X-CSRF-TOKEN': _token},
          url: url,
          data: {hadding:hadding,id_exam:id_exam},
          type: 'Post',
          cache:false,      
          success:function(data)
          {         
            $('#div_exam_user').empty();
            $('#div_exam_user').append(data);
            $('#div_exam_user').show(1000);
            $('#div_exam_').hide(900);
          },
          error: function (jqXHR,xhr, ajaxOptions, thrownError) {
            Swal.fire("Error","Thất bại", "warning");
          }

        });
}

function back_exam_list()
{
  $('#div_exam_').show(1000);
  $('#div_exam_user').hide(900);
}

@endif
</script>
@endsection
