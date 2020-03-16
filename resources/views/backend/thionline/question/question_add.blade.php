<div class="card card-primary" id="frm_add_question" style="display: none;">
    <form id="create_question" name ="create_question"action="post">
          @csrf
      <div class="card-header">
        <h3 class="card-title">Add question</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label>Choose type question</label>
          <select class="form-control select2" style="width: 100%;" id="type_question" name="type_question">
            <option selected="selected" value="1">Câu hỏi có 1 lựa chọn đúng</option>
            <option value="2">Câu hỏi nhiều lựa chọn đúng</option>
            <option value="3">Điền vào chổ trống</option>
          </select>
        </div>
        <div class="form-group">
          <label>Number answer</label>
          <select class="form-control select2 " style="width: 100%;" id="txt_number_answer" name="txt_number_answer">           
            @for($i=2;$i<=10;$i++)
            <option {{$i==4? 'selected=selected':''}}>{{$i}}</option>
            @endfor
          </select>
        </div>

        <div class="form-group">
          <label>Topic</label>
          <select class="form-control select2" style="width: 100%;" id="txt_topic" name='txt_topic'>
            @foreach($question as $topic)
            <option value="{{$topic->id_topic}}">{{$topic->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Content</label>
          <textarea class="form-control" rows="3" placeholder="Nội dung câu hỏi......." style="height: 103px;" id="txt_content" name="txt_content"></textarea>
        </div>
        

        <div class="form-group" id='div_input_ansser'>

        </div>
        

        <div class="form-group " id='div_input_ansser_checkbox'>

        </div>



        

        <!-- /.form group -->
      
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button id="btn_cancel_form_add_question" type="button" class="btn btn-danger float-right">Cancel</button>
        <button id="btn_save_form_add_question" type="button" class="btn btn-primary float-right">Save</button>
      </div>
    </form>
</div>

