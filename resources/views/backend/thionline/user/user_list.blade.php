@extends('backend.thionline.page')

{{--  --}}
@section('content-header')

<div class="row mb-2">
  <div class="col-sm-6">
  <h1 class="m-0 text-dark">Danh sách người dùng</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">User list</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@endsection


{{-- Noi dung web --}}
@section('contents')
<div class="row" id="div_load_list_user">
  <div class="col-12">
    <div class="card">
      {{-- <div class="card-header">
        <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
      </div> --}}
      <div class="card-body">
        <table class="display responsive" id="list_user" style="width:100%">
          <thead>
              <tr>
                <th>Id</th>
                <th>img</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Email</th>        
                <th>Phone</th>        
                <th>Satus</th>
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
<div class="row" id="div_load_profile">

</div>
@csrf
@endsection


{{--  --}}
@section('custom_css')
  <!-- Ionicons font bieu tuong cho dashbroad --> 
  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"> 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
@endsection


{{--  --}}
@section('custom_js')
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
<script src="plugins/sweetalert2/sweetalert2.all.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>


<script>

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
        ajax: '{!! route('user.handling_ajax_user') !!}',
        columns: [
                { data: 'id', name: 'users.id' },
                { data: 'img', name: 'users.img' },
                { data: 'name', name: 'users.name' },
                { data: 'sex', name: 'users.sex'},
                { data: 'email', name: 'users.email' },
                { data: 'phone', name: 'users.phone' },
                { data: 'status', name: 'users.status' },
                { data: 'created_at', name: 'users.created_at' },
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

// load profile theo user
function load_profile(id_user)//dung chung mot ham xu ly ben user_controller hadding_user() luôn chung chô load huyện tinh, 
{
    var _token= $("input[name=_token]").val();;
    var hadding='load_profile_id'
      var url='{{route('users.hadding')}}';//url chuyen huong xu ly usercontroller
      $.ajax({
        headers: { 'X-CSRF-TOKEN': _token},
        url: url,
        data: {hadding:hadding,id_user:id_user},
        type: 'Post',
        cache:false,      
        success:function(data)
        {          
          $('#div_load_profile').empty();
          $('#div_load_profile').append(data);
          $('#div_load_profile').show(1000);
          $('#div_load_list_user').hide(900);
        },
        error: function (jqXHR,xhr, ajaxOptions, thrownError) {
          Swal.fire("Error","Thất bại", "warning");
        }

      });
}

function back_list_user()
{
  $('#div_load_list_user').show(1000);
  $('#div_load_profile').hide(800);
}

</script>



@endsection
