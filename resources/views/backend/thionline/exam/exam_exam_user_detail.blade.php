<body onload="Print();">
<link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css', []) }}">
<div style="width:100%;">
    <img src="{{ url('adminlte/upload/header.jpg', []) }}">
   
    <table style="width: 100%;" >
        <tr>
            <td>
                <h1 style="text-align: center; font-size: 400%;" >KẾT QUẢ THI</h1>
            </td>
        </tr>
    </table>
    <table style="width: 100%;" border="1" >
        <tr>
            <td>
                <h1 id="hoten">Họ tên: {{$exam->name_user}}</h1>
                <h1 >Số câu đúng:{{$exam->number_true}}/ {{$exam->number_question}} câu</h1>
                <h1> Mã đề thi: {{$exam->id_exam}}</h1>
            </td>
            <td>
                <h1 >Tên đề thi: {{$exam->name_exam}}</h1>
                <h1 >Ngày thì: {{$exam->date_time_test}}.</h1>
                <h1>Số lượng câu hỏi: {{$exam->number_question}} câu.</h1>
                <h1>Thời gian làm bài: {{$exam->time_test}} phút.</h1> 
            </td>
        </tr>
    </table>
    <h1 >Bài thi chi tiết:</h1>

@for($ii=0;$ii<count($list_id_question);$ii++)
    @foreach($question as $qtion)
        @if($qtion->id_question==$list_id_question[$ii])
        <div class="question_div">
            <div class="question_container" style="font-size: 37px;">
                <b>Câu hỏi số {{$loop->index+1}}:</b>[{{$qtion->id_question}}] {{$qtion->content}}		 
            </div>
            <div class="option_container">

                    <table>
                        <tbody>
                            @if($qtion->type==3)
                                @foreach($result_exception as $re_excroption)
                                    @if($re_excroption->id_question==$qtion->id_question&& $re_excroption->id_result_exam==$exam->id_result_exam)
                                        <tr style="width: 200px; font-size: 40px;">	
                                            <td > 
                                                {{$re_excroption->content}}
                                            </td>  
                                            <td>
                                                @if($re_excroption->true==1)
                                                <i class="far fa-check-square"></i>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else  
                                @foreach($question_option as $qtion_option)                                                            
                                        @if($qtion_option->id_question==$qtion->id_question)
                                            <tr style="width: 200px; font-size: 40px;">	
                                                <td >
                                                    <?php
                                                        $temp=0;
                                                    ?>
                                                        @for($i=0;$i<count($list_id_option);$i++)
                                                            @if($list_id_option[$i]==$qtion_option->id_question_option)
                                                                <?php
                                                                    $temp=$temp+1;
                                                                ?>
                                                                @break                                                     
                                                            @endif                                                    
                                                        @endfor
                                                    @if($temp>0)                                                
                                                        <b>{{$qtion_option->content_option}} </b>                                                    
                                                    @else
                                                        {{$qtion_option->content_option}} 
                                                    @endif                                                
                                                </td>   
                                                <td>
                                                </td>
                                                <td style="width: 201px;padding-left: 30px; text-align: center;">
                                                    @if($qtion_option->id_question==$qtion->id_question&& $qtion_option->true==1)
                                                    <i class="far fa-check-square"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>			
            
            </div> 
        </div>
        </br>     
        @endif        
    @endforeach
@endfor
</div>
</body>

<script type="text/javascript">
	var uri = window.location.toString();

if (uri.indexOf("?") > 0) {
    var clean_uri = uri.substring(0, uri.indexOf("?"));
    window.history.replaceState({}, document.title, clean_uri);
}
window.close();
window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
window.print();

window.onfocus=function(){ window.close();}
</script>