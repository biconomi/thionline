<div class="row">
  <div class="col-md-9">
    <div class="card card-default color-palette-box">
      <div id="printContent">
        <form action="" name="nopbai" id="nopbai">
            @csrf
            <div class="card-header">      
              <h3 class="card-title">
                <i class="fas fa-tag"></i>
                ĐỀ THI:
                @foreach($exam as $ex)
                    {{$ex->name}} [{{$ex->id_exam}}]
                    <input type="hidden" id='end_time' value="{{\Carbon\Carbon::now()->addMinutes($ex->time_test)}}">      
                    @break;
                @endforeach
              </h3>
              <button  type="button"id="print-friendly" class="btn btn-xs btn-default" style="float:right;display: none;"><i class="fas fa-print"></i>In kết quả</button>
            </div>
            <div id="result_tesst">

            </div>

            <div class="card-body" id="chitietdethi">      
                @foreach($exam as $ex)
                    <div class="{{$ex->type==1?'callout callout-info':'callout callout-warning'}}" id="card{{$ex->id_question}}">
                    <h5>Câu hỏi {{$loop->index+1}}: [{{$ex->id_question}}]  {{$ex->content}}</h5>
                    <div class="form-group">
                        @foreach($question_option as $qo)
                            @if($qo->id_question==$ex->id_question)
                                @if($ex->type==1)
                                <div class="icheck-success">
                                <input type="radio" id="radio_option{{$qo->id_question_option}}" name="radio_option{{$qo->id_question}}" value="{{$qo->id_question_option}}" onchange="select_id_option_radio('{{$qo->id_question}}')">
                                <label  style="font-weight: normal !important;" for="radio_option{{$qo->id_question_option}}" id="labal{{$qo->id_question_option}}">{{$qo->content_option}}</label>       
                                </div>
                                @endif
                                @if($ex->type==2)
                                <div class="icheck-success">
                                <input type="checkbox" id="radio_option{{$qo->id_question_option}}" name="radio_option{{$qo->id_question}}" value="{{$qo->id_question_option}}" onchange="select_id_option('{{$qo->id_question_option}}','{{$qo->id_question}}')">
                                    <label  style="font-weight: normal !important;" for="radio_option{{$qo->id_question_option}}" id="labal{{$qo->id_question_option}}">{{$qo->content_option}}</label>                
                                </div>                    
                                @endif

                            @endif
                        @endforeach
                        @if($ex->type==3)
                            <textarea class="form-control" rows="3" placeholder="Nội dung câu trả lời." style="height: 103px;" id="{{$ex->id_question}}" name="{{$ex->id_question}}" maxlength="200"  onchange="get_txt_content('{{$ex->id_question}}','txt_content{{$ex->id_question}}')"></textarea>
                        @endif

                    </div>
                </div>
                @endforeach
                <div class="card-footer" id="btn_nopbai">
                <button id="btn_noinoibai" type="button" class="btn btn-primary">Nộp bài</button>
                </div>
            </div>
            <!-- /.card-body -->
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-3 text-center">
    <section id="timer">
      <div class="countdown-wrapper text-center mb20">
          <div class="card">
              <div class="card-header">
                  Thời gian còn lại của để thi
              </div>
              <div class="card-block">
                <div id="countdown">
                    <div class="well">
                        <span id="min" class="timer bg-info">120</span>
                    </div>
                </div>
              </div>
              <div class="card-footer">
              </div>
          </div>
    </div>
    
</section>
  </div>
</div>
<style>
      @import url(http://fonts.googleapis.com/css?family=Lato:100,400);
    .mb20{
        margin-bottom:20px;
    }
    section {
        padding: 0px;
    }
    #timer .countdown-wrapper {
        margin: 0 auto;
    }
    #timer #countdown {
        font-family: 'Lato', sans-serif;
        text-align: center;
        color: #eee;
        text-shadow: 1px 1px 5px black;
        padding: 40px 0;
    }
    #timer .countdown-wrapper #countdown .timer {
        margin: 10px;
        padding: 20px;
        font-size: 20px;
        border-radius: 50%;
        cursor: pointer;
    }
    #timer .col-md-4.countdown-wrapper #countdown .timer {
        margin: 10px;
        padding: 20px;
        font-size: 35px;
        border-radius: 50%;
        cursor: pointer;
    }
    #timer .countdown-wrapper #countdown #hour {
        -webkit-box-shadow: 0 0 0 5px rgba(92, 184, 92, .5);
        -moz-box-shadow: 0 0 0 5px rgba(92, 184, 92, .5);
        box-shadow: 0 0 0 5px rgba(92, 184, 92, .5);
    }
    #timer .countdown-wrapper #countdown #hour:hover {
        -webkit-box-shadow: 0px 0px 15px 1px rgba(92, 184, 92, 1);
        -moz-box-shadow: 0px 0px 15px 1px rgba(92, 184, 92, 1);
        box-shadow: 0px 0px 15px 1px rgba(92, 184, 92, 1);
    }
    #timer .countdown-wrapper #countdown #min {
        -webkit-box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
        -moz-box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
        box-shadow: 0 0 0 5px rgba(91, 192, 222, .5);
    }
    #timer .countdown-wrapper #countdown #min:hover {
        -webkit-box-shadow: 0px 0px 15px 1px rgb(91, 192, 222);
        -moz-box-shadow: 0px 0px 15px 1px rgb(91, 192, 222);
        box-shadow: 0px 0px 15px 1px rgb(91, 192, 222);
    }
    #timer .countdown-wrapper #countdown #sec {
        -webkit-box-shadow: 0 0 0 5px rgba(2, 117, 216, .5);
        -moz-box-shadow: 0 0 0 5px rgba(2, 117, 216, .5);
        box-shadow: 0 0 0 5px rgba(2, 117, 216, .5)
    }
    #timer .countdown-wrapper #countdown #sec:hover {
        -webkit-box-shadow: 0px 0px 15px 1px rgba(2, 117, 216, 1);
        -moz-box-shadow: 0px 0px 15px 1px rgba(2, 117, 216, 1);
        box-shadow: 0px 0px 15px 1px rgba(2, 117, 216, 1);
    }
    #timer .countdown-wrapper .card .card-footer .btn {
        margin: 2px 0;
    }
    @media (min-width: 1200px) {
      #timer{
          position: fixed; 
          right: 0px;
          width: 21%;
        }
      #timer .countdown-wrapper #countdown .timer {
          margin: 10px;
          padding: 20px;
          font-size: 20px;
          border-radius: 50%;
          cursor: pointer;
      }
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        #timer{
          position: fixed; 
          right: 0px;
        }
        #timer .countdown-wrapper #countdown .timer {
            margin: 10px;
            padding: 20px;
            font-size: 20px;
            border-radius: 50%;
            cursor: pointer;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
      #timer{
          position: fixed; 
          right: 0px;
          max-width: 26%;
        }
        #timer .countdown-wrapper #countdown .timer {
            margin: 10px;
            padding: 20px;
            font-size: 20px;
            border-radius: 50%;
            cursor: pointer;
        }
    }
    @media (max-width: 768px) {
      #timer{
          position: fixed; 
          right: 0px;
          max-width: 26%;
        }
        #timer .countdown-wrapper #countdown .timer {
            margin: 10px;
            padding: 20px;
            font-size: 26px;
            border-radius: 50%;
            cursor: pointer;
        }
    }
    @media (max-width: 767px) {
      #timer{
          position: fixed; 
          right: 0px;
          display: none;
        }
        #timer .countdown-wrapper #countdown #hour,
        #timer .countdown-wrapper #countdown #min,
        #timer .countdown-wrapper #countdown #sec {
            font-size: 60px;
            border-radius: 4%;
        }
    }
    @media (max-width: 576px){
      #timer{
          position: fixed; 
          right: 0px;
        }
        #timer .countdown-wrapper #countdown #hour,
        #timer .countdown-wrapper #countdown #min,
        #timer .countdown-wrapper #countdown #sec {
            font-size: 25px;
            border-radius: 4%;
        }
        #timer .countdown-wrapper #countdown .timer {
            padding: 13px;
            display: none;
        }
    }
</style>
<script>
$(document).ready(function(){
    	var min=$('#end_time').val();
      $('#min').countdown(min, function(event) { 
          $(this).text(event.strftime('%H:%M:%S')); 
      }).on('finish.countdown', function(event) 
      { 
        btn_nopbai({{$id_result_exam}});
      });

	    $('#btn_noinoibai').click(function(){
          Swal.fire({
          title: 'Bạn có chắc chắn hoàn thành bài thi không?',
          text: "Kết thúc thi luôn!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Nộp bài thi!'
          }).then((result) => {
          if (result.value) {
            Swal.fire('Thành công!','Chúc bạn mai mắn!','success');
            btn_nopbai({{$id_result_exam}});
            $('#min').countdown('pause');
          }
          });
	    });
	});

$('#print-friendly').click(function()
{
  $('#printContent').printThis();
  $('#print-friendly').remove();
});

function hidden_test_datail()
{
  $('#chitietdethi').hide(1);
  $('#btn_nopbai').remove();
  load_lai_cau_dung();
  
}
function show_test_datail()
{
  $('#chitietdethi').show(100);
  $('#xemlai').remove();
  $('#print-friendly').show(100);
}

//lua chon cua nguoi thi
var option_user_select=[];

function select_id_option(id_option,id_question)
{

    // alert(id);
    var checked = $("#radio_option"+id_option+":checked").length;
    //alert(checked);
    if (checked == 0) //bo chon
    { 
      for(var i=0;i<option_user_select.length;i++)
        {
          var myObj = JSON.parse(option_user_select[i]); 
          if(myObj.id_question==id_question&&myObj.id_option==id_option)//trung
          {          
            option_user_select.splice(i,1);       
          }
        }
    } 
    else 
    {
      if(option_user_select.length==0)//neu mang con rong
      {
        var save='{"id_question":'+id_question+',"id_option":'+id_option+'}';
        option_user_select.push(save);
      }
      else
      {
        for(var i=0;i<option_user_select.length;i++)
        {
          var myObj = JSON.parse(option_user_select[i]); 
          if(myObj.id_question==id_question&&myObj.id_option==id_option)//trung
          {          
            option_user_select.splice(i,1);       
          }
        }
        // id_option_temp.push(id_option);
        var save='{"id_question":'+id_question+',"id_option":'+id_option+'}';
        option_user_select.push(save);
      }
    }
    // for(var i=0;i<option_user_select.length;i++)
    // {
    //   // alert(option_user_select[i]);  
    //   var myObj = JSON.parse(option_user_select[i]);  
    //   console.log(myObj.id_question,myObj.id_option);
    // }
}

var phantach=[];//du lieu chuyen doi
function chuanhoa()
{
    for(var i=0;i<option_user_select.length;i++)
    {
      // alert(option_user_select[i]);  
      var myObj = JSON.parse(option_user_select[i]);  
      // console.log(myObj.id_question,myObj.id_option);
      var save='{"id_option":'+myObj.id_option+'}';
      phantach.push(save);
    }
}

//lua chon cua nguoi thi radio
function select_id_option_radio(id)
{
  // alert(id);
    var radioValue = $("input[name='radio_option"+id+"']:checked").val();
    if(radioValue)
    {    
      if(option_user_select.length==0)//neu mang con rong
      {
        var save='{"id_question":'+id+',"id_option":'+radioValue+'}';
        option_user_select.push(save);
      }
      else
      {
        for(var i=0;i<option_user_select.length;i++)
        {
          var myObj = JSON.parse(option_user_select[i]); 
          if(myObj.id_question==id)//trung
          {
            option_user_select.splice(i,1);         
          }
        }
        var save='{"id_question":'+id+',"id_option":'+radioValue+'}';
        option_user_select.push(save);
      }//end else
    }                
       
}
function active_true(id_option)//hien thi nhưng cau dung
{
    // <i style="color:green;font-size:larger;" class="fas fa-check-square"></i>  
}
//ngung su dung
function get_txt_content(id_question,id)//bam bat loi
{
      var value=$('#'+id).val();
      // if(option_user_select.length==0)//neu mang con rong
      // {
      //   var save='{"id_question":'+id_question+',"id_option":0}';
      //   option_user_select.push(save);
      // }
      // else
      // {
      //   for(var i=0;i<option_user_select.length;i++)
      //   {
      //     var myObj = JSON.parse(option_user_select[i]); 
      //     if(myObj.id_question==id_question)//trung
      //     {          
      //       id_option_temp=myObj.id_option;
      //       option_user_select.splice(i,1);       
      //     }
      //   }
      //   var save='{"id_question":'+id_question+',"id_option":0}';
      //   option_user_select.push(save);
      // }//end else

}

</script>