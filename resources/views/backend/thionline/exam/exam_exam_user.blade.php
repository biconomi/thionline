{{-- xem bang tong hop nguoi tham gia de thi --}}
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tổng hợp đề thi: </h3>

      <div class="card-tools">        
        <button onclick="back_exam_list();" type="button"class="btn-sm btn-primary" style="float: right;"><i class="fas fa-print"></i>Back</button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Họ tên</th>
            <th>Trạng thái</th>
            <th style="width: 40px">Đúng</th>
            <th style="width: 40px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($result_exam as $re_ex)
          <tr>
            <td>1.</td>
            <td>{{$re_ex->name}}</td>
            <td>
             @if($re_ex->status==0)
                <small class="badge badge-success">&nbsp&nbsp&nbsp&nbsp &nbsp Thi xong &nbsp&nbsp &nbsp &nbsp</small>
             @endif

            @if($re_ex->status==1)
                <small class="badge badge-success">&nbsp&nbsp&nbsp&nbsp &nbsp Đang thi &nbsp&nbsp &nbsp &nbsp</small>
            @endif

            @if($re_ex->status==3)
                <small class="badge badge-danger">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp Bỏ thi &nbsp&nbsp&nbsp&nbsp &nbsp </small>
            @endif

            @if($re_ex->status==4)
                <small class="badge badge-danger">Hệ thống đóng</small>>
            @endif

            @if($re_ex->status==5)
                 <small class="badge badge-warning">Chờ chấm thi &nbsp&nbsp </small>
            @endif

            </td>
            <td><span class="badge bg-success">{{$re_ex->number_true}}</span></td>
            <td><a href="{{route('exam_export.detail',['id_result_exam'=>$re_ex->id_result_exam])}}" target="_blank"><span class="btn btn-outline-success"><i class="fas fa-download"></i></span></a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-footer">
        <a href="{{route('exam_export',['id_exam'=>$id_exam])}}"><button type="button" id="print-friendly" class="btn-sm btn-default" style="float: right;"><i class="fas fa-print"></i>In kết quả</button></a>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
