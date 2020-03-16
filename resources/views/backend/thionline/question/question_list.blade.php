@extends('backend.thionline.page')

{{--  --}}
@section('content-header')
<div class="row mb-2">
  <div class="col-sm-6">
  <h1 class="m-0 text-dark">Question list</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">Question list</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection

{{-- Noi dung web --}}

@section('contents')

<div class="row">
  <div class="col-12">
  {{-- form thêm question --}}
    @include('backend.thionline.question.question_add')
    
    <div class="card" id="question_list">
      <div class="card-header">
        <button id="btn_load_form_add_question" type="button" class="btn btn-primary">Add</button>
      </div>      
      <div class="card-body">
        <table class="display responsive" id="list_user" style="width:100%">
          <thead>
              <tr>
                <th>Question</th>
                <th>Topic</th>     
                <th>Satus</th>
                <th>Code</th>
                <th>Create</th>
                <th>Action</th>

              </tr>
          </thead>
        </table>
        <div id="paginationListUsers" style="margin-bottom: 10px; display: flex;">
          <input class="form-control" type="text" placeholder="Page" id="inputPaginationListUsers" style="width: 60px; margin-right: 5px;">
          <button class="btn btn-primary" id="buttonPaginationListUsers">Go</button>
        </div>
      </div>
    </div>

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


@endsection





{{--  --}}
@section('custom_js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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


<script>

//load form add question 
// 

window.onload = function()
	 {	
    choose_type_option();
   };
   

$('#type_question').change(function(){
  choose_type_option();
});

// loại cau hỏi se load lên các loại tương ứng
function choose_type_option()
{
  if($('#type_question').val()==1) //Lua chonj 1 cau dung
  {
    luachon1caudung();
  }
  else
  {
    if($('#type_question').val()==2)//Lua chon nhieu cau dung
    {
      lua_chon_nhieu_cau_dung();
    }
    else//tra lo nhap lieu
    {
      luachonhaplieu();
    }

  }

}

function luachon1caudung()
{
    remove_txtrowinput();//xoa het cau tra loi
    remove_txtrowinput_checkbox();
    add_txtrowinput($('#txt_number_answer').val());
}

function lua_chon_nhieu_cau_dung()
{ 
  remove_txtrowinput_checkbox();
  remove_txtrowinput();//xoa het cau tra loi
  add_txtrowinput_checkbox($('#txt_number_answer').val());
}


function luachonhaplieu()
{ 
  remove_txtrowinput_checkbox();
  remove_txtrowinput();//xoa het cau tra loi
}



// thay doi so lượng cáu tra lời
  $('#txt_number_answer').change(function(){   
    choose_type_option();
  });




	function add_txtrowinput(number)
	{
    for(var i=1; i<=number;i++)
    {
      if(i==1)
      {
        $('#div_input_ansser').append
    ('<div class="icheck-success"><input type="radio" name="txt_ansser[]"  value="'+i+'" checked="" id="input_ansser'+i+'"><label for="input_ansser'+i+'">Lựa chọn thứ '+i+'</label><input type="text" class="form-control" name="input_ansser'+i+'" id="txt_input_ansser'+i+'" placeholder="Nội dung câu trả lời '+i+'"></div>');
      }
      else
      {
        $('#div_input_ansser').append
    ('<div class="icheck-success"><input type="radio" name="txt_ansser[]" value="'+i+'" id="input_ansser'+i+'"><label for="input_ansser'+i+'">Lựa chọn thứ '+i+'</label><input type="text" class="form-control" name="input_ansser'+i+'" id="txt_input_ansser'+i+'" placeholder="Nội dung câu trả lời '+i+'"></div>');

      }

    }		

  }
  
	function add_txtrowinput_checkbox(number)
	{
    for(var i=1; i<=number;i++)
    {
      if(i==1)
      {
        $('#div_input_ansser_checkbox').append
    ('<div class="icheck-success"><input type="checkbox" name="txt_ansser_checkbox[]"  value="'+i+'" checked="" id="checkboxSuccess'+i+'"><label for="checkboxSuccess'+i+'">Lựa chọn thứ '+i+'</label><input type="text" class="form-control" name="input_ansser_check'+i+'" id="input_ansser_check'+i+'" placeholder="Nội dung câu trả lời"></div>');
      }
      else
      {
        $('#div_input_ansser_checkbox').append
        ('<div class="icheck-success"><input type="checkbox" name="txt_ansser_checkbox[]"  value="'+i+'" id="checkboxSuccess'+i+'"><label for="checkboxSuccess'+i+'">Lựa chọn thứ '+i+'</label><input type="text" class="form-control" name="input_ansser_check'+i+'" id="input_ansser_check'+i+'" placeholder="Nội dung câu trả lời"></div>');

      }

    }		

  }
	function remove_txtrowinput_checkbox()
	{
		$('#div_input_ansser_checkbox').empty();
	}


	function remove_txtrowinput()
	{
		$('#div_input_ansser').empty();
	}
  // 
  $('#btn_load_form_add_question').click(function(){
    $("#frm_add_question").toggle(1500);
    $("#question_list").hide(1500);
  });

  $('#btn_cancel_form_add_question').click(function(){
    $("#frm_add_question").toggle(1000);
    $("#question_list").show(1500);
  });

  $('#btn_save_form_add_question').click(function(){
    if(validateform_question_erros()<1)
    {
          update_user('create');
    }
    else
    {
      alert('Loi roi');
    }




  });


function delete_question(id_question)//delete question
{
  var _token=document.forms["create_question"].elements["_token"].value;
		var form_data = new FormData(document.forms.create_question);
		form_data.append('handling', 'delete');   // add haading xu ly ben controller
    form_data.append('id_question', id_question);   // add them id câu hỏi để xóa

		var url='{{route('question.handling_ajax_create')}}';
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
        if(data=='true')
				{ 
          $('#'+id_question).remove();
				}
				else
				{
					 swal("Xóa","không thành công", "warning"); 
				}
			},
			error: function (jqXHR,xhr, ajaxOptions, thrownError) {
        swal("Xóa","không thành công", "warning"); 
			}

		});
}
function update_user(handling)//create va update user
{

	if(handling=='create')
	{ 
		var _token=document.forms["create_question"].elements["_token"].value;
		var form_data = new FormData(document.forms.create_question);
		form_data.append('handling', handling);   // add haading xu ly ben controller
		var url='{{route('question.handling_ajax_create')}}';
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
        if(data=='true')
				{ 
             swal("Thành công","Cập nhật thành công", "success");
             $('#create_question')[0].reset();
             choose_type_option();
				}
				else
				{
					 swal("Thêm mới","không thành công", "warning"); 
				}
			},
			error: function (jqXHR,xhr, ajaxOptions, thrownError) {
        swal("Thêm mới","Thất bại", "warning"); 
			}

		});
	}
	if (handling=='update') 
	{
		var _token=document.forms["frmEditteUser"].elements["_token"].value;
		var form_data = new FormData(document.forms.frmEditteUser);
		form_data.append('handling', handling);   // add haading xu ly ben controller

		var url=Url_hadling_user;
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
				//$.toaster({ priority : 'success', title : 'Title', message : 'Your message here'});
				if(data=='true')
				{ 
					   swal("Thành công","Cập nhật thành công2", "success");
				}
				else
				{
					 swal("Thêm mới","không thành công", "warning"); 
				}		
			},
			error: function (jqXHR,xhr, ajaxOptions, thrownError) {
				 
			}

			});
	}	
}



function validateform_question_sucsess()
{

  $('#type_question').attr('class','form-control is-valid');
  $('#txt_number_answer').attr('class','form-control is-valid');
  $('#txt_topic').attr('class','form-control is-valid');
  $('#txt_content').attr('class','form-control is-valid');

  if($('#type_question').val()==1) //Lua chonj 1 cau dung
  {
    for(var i=1;i<= $('#txt_number_answer').val();i++)
    {
      $('#txt_input_ansser'+i).attr('class','form-control is-valid');  
    }
  }
  else
  {
      if($('#type_question').val()==2) //lua chon nhieu cau dung
      {
          for(var i=1;i<= $('#txt_number_answer').val();i++)
          {
            $('#input_ansser_check'+i).attr('class','form-control is-valid');  
          }
      }
      else
      {
        
      }
  }


  

 


}

function validateform_question_erros()
{
  validateform_question_sucsess();
  var validate=0;
  if($('#type_question').val()==1) //Lua chonj 1 cau dung
  {    
    if($.trim($('#type_question').val())=="")
    {
      $('#type_question').attr('class','form-control is-invalid');
      validate=1;
    }
    if($('#txt_number_answer').val()=="")
    {
      $('#txt_number_answer').attr('class','form-control is-invalid');
      validate=1;
    }
    if($.trim($('#txt_topic').val())=="")
    {
      $('#txt_topic').attr('class','form-control is-invalid');
      validate=1;
    }
    if($.trim($('#txt_content').val())=="")
    {
      $('#txt_content').attr('class','form-control is-invalid');
      validate=1;
    }

    for(var i=1;i<= $('#txt_number_answer').val();i++)
    {
      if($.trim($('#txt_input_ansser'+i).val())=="")
      {
        $('#txt_input_ansser'+i).attr('class','form-control is-invalid');
        validate=1;
      }
    }
    
    
  }
  else
  {
    if($('#type_question').val()==2)//Lua chon nhieu cau dung
    {
        if($.trim($('#type_question').val())=="")
        {
          $('#type_question').attr('class','form-control is-invalid');
          validate=1;
        }
        if($('#txt_number_answer').val()=="")
        {
          $('#txt_number_answer').attr('class','form-control is-invalid');
          validate=1;
        }
        if($.trim($('#txt_topic').val())=="")
        {
          $('#txt_topic').attr('class','form-control is-invalid');
          validate=1;
        }
        if($.trim($('#txt_content').val())=="")
        {
          $('#txt_content').attr('class','form-control is-invalid');
          validate=1;
        }
        // bien kiem tra co check chua
        var check=0;
        for(var i=1;i<= $('#txt_number_answer').val();i++)
        {
          if($.trim($('#input_ansser_check'+i).val())=="")
          {
            $('#input_ansser_check'+i).attr('class','form-control is-invalid');
            validate=1;
          }
          if($('#checkboxSuccess'+i).is(":checked"))
          {
            check=check+1;
          }
        }
        if(check==0)
        {
          swal("Không thành công","Phải có ít nhất 1 câu đúng", "warning"); 
          validate=1;
        }
    }
    else//tra lo nhap lieu
    {
      if($.trim($('#txt_content').val())=="")
      {        
        $('#txt_content').attr('class','form-control is-invalid');
        validate=1;
      }
    }

  }
  return validate; 
}





// kết thúc

$("input[data-bootstrap-switch]").each(function(){
  $(this).bootstrapSwitch('state', $(this).prop('checked'));
});
var page_customer;
$(function() {
  page_customer= $('#list_user').DataTable({
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
        ajax: '{!! route('question.handling_ajax_question') !!}',
        columns: [
                { data: 'content', name: 'question.content' },
                { data: 'name', name: 'topic.name' },
                { data: 'status', name: 'question.status' },
                { data: 'question_id', name: 'id_question' },
                { data: 'created_at', name: 'question.created_at' },
                { data: 'action', name: 'action'}  

        ]
    });
});
$('#buttonPaginationListUsers').click(function () {
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





</script>


@endsection
