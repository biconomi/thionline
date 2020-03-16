 
    <div class="card-body">
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <i style="color:#28a745; font-size:18pt!important;" class="far fa-check-square"></i> &nbsp;&nbsp; &nbsp; &nbsp; <b>Số lượng câu đúng:</b> <a class="float-right">{{$number_true}} câu</a>
            </li>
            <li class="list-group-item">
              <i style="color:red; font-size:18pt!important;" class="far fa-check-square"></i> &nbsp;&nbsp; &nbsp; &nbsp; Nếu đề có câu tự luần thì phải chờ chấm thi sau
           </li>
          </ul>        
    </div>   
    <div class="card-footer" id="xemlai">
        <button  type="button" class="btn btn-primary" onclick="show_test_datail()">Xem lại</button>
    </div>



<script src="plugins/exam/printThis.js"></script>    
<script>
function load_lai_cau_dung()
{
    @for($i=0;$i<count($list_option);$i++)
    $('#labal{{$list_option[$i]}}').append('&nbsp;&nbsp; &nbsp; &nbsp;<i style="color:blue;font-size: larger;" class="far fa-check-square"></i>');
    @endfor
}
</script>