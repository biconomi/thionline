<div class="col-sm-12" >
    <div class="card card-primary" id="frm_add_exam" style="display: none;">
        <form id="create_exam" name ="create_exam"action="post">
            @csrf
        <div class="card-header">
            <h3 class="card-title">Thêm đề thi</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
            <label>Tên đề thi</label>
            <input type="text" class="form-control" id="txt_nam_exam" name="txt_nam_exam" placeholder="Tên đề thi" maxlength="100">
            </div>
            <div class="form-group has-error">
            <label>Chủ đề</label>
            <select class="select2" multiple="multiple" id="txttopic" name ="txttopic" data-placeholder="Chọn chủ đề" style="width: 100%;">
                @foreach($topic as $key => $tp)
                    <option value='{{$tp->id_topic}}'>{{$tp->name}}</option>
                @endforeach
            </select>  
            <div id="error_txttopic">
                
            </div>          
            
            </div>
            <div class="form-group">
                <label>Số lượng câu hỏi</label>
                <input type="text" name="txt_number" id="txt_number" class="form-control" value="30" required="" min="10" max="100" maxlength="3">
                </div>
            <div class="form-group">
            <label>Thời gian làm bài</label>
            <input type="text" name="txt_time_exam" id="txt_time_exam" class="form-control" value="30" required="" min="10" max="100" maxlength="3">
            </div>
            <div class="form-group">
                <label>Ngày cho phép thi</label>
                <div class="input-group">
                  <div class="input-group-prepend">                                             
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>                  
                <input type="text" name="date_start"  id="date_start" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="{{\Carbon\Carbon::now()->year}}-mm-dd" data-mask>
                </div>
                <!-- /.input group -->
              </div>
              
            <div class="form-group">
                <div class="icheck-success">
                <input type="radio" id="radio_question_topic_auto" name="radio_question"  value='1' checked="" >
                <label for="radio_question_topic_auto">Lựa chọn câu hỏi tự động</label>
                </label>
                </div>
                <div class="icheck-warning">
                <input type="radio" id="radio_question_topic_manual" name="radio_question" value="2">
                <label for="radio_question_topic_manual">Lưa chọn câu hỏi thủ công</label>
                </label>
                </div>
            </div>


            <div class="form-group">
            <label>Mô tả</label>
            <textarea class="form-control" rows="3" placeholder="Mô tả, ghi chú...." style="height: 103px;" id="txt_content" name="txt_content"></textarea>
            </div>   
            <div class="form-group" id='div_input_select_question'>
                
            </div>            

            <!-- /.form group -->
        
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button id="btn_cancel_form_add_exam" type="button" class="btn btn-danger float-right">Cancel</button>
            <button id="btn_save_form_add_question" type="button" class="btn btn-primary float-right" onclick="exam_add();">Save</button>
        </div>
        </form>
    </div>
</div>


<div class="col-sm-8">

</div>
