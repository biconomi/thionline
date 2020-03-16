<?php

namespace App\Http\Controllers\thionline\exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Helper;
use Auth;
use Laratrust;
use DB;
use Carbon\Carbon;
use App\exam;
use App\exam_question;
use App\result_exam;
use App\result_exception;
use PDF;
class examController extends Controller
{
    //
    public function exam_list()
    {   
        $data['topic']=DB::table('topic')->where('status','=',1)->get();
        // $data['exam_list']=DB::table('topic')           
        //                         ->
        return view('backend.thionline.exam.exam_list',$data);  
    }
    public function exam_choose()//load danh sach đề thi. 
    {
        // $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        // //dd("Public IP: ".$ip); //"Public IP: 24.62.137.161"
        // $clientIP = \Request::ip();
        // dd($clientIP);
        //chọn đề thi phu hop theo user.

        // quet het danh sach cho den han  la status 2 sau do quet ngay neu dung ngay thi update trang thai sang 1 de dc thi
        // khi het han ngay thi update lai trang thai het han la 3
        
        $this->auto_config_exem_date();
        $data['exam']=DB::table('exam')
                ->where('status', '=',1)
                // ->where('type')
                ->get();    
        return view('backend.thionline.exam.exam_choose',$data);          
    }
    public function auto_config_exem_date()//chuyen trang thai cau hoi khi het han va thi chuan bi thi
    {
        $exam =DB::table('exam')
            ->where('status','=',2)
            ->wheredate('date_begin', '=', Carbon::now())
            ->select('id_exam') 
            ->get();
        foreach($exam as $ex)//chuyen trang thai de thi
        {
        $exams=exam::where('id_exam',$ex->id_exam)
                            ->update(['status' => 1]);
        }
        $exam_3 =DB::table('exam')//het han
                ->where('status','=',1) 
                ->wheredate('date_begin', '<', Carbon::now())
                ->select('id_exam') 
                ->get();
        foreach($exam_3 as $ex)
        {
            $exam_3=exam::where('id_exam',$ex->id_exam)
                            ->update(['status' => 3]);
        }

    }

    public function handling_ajax_exam_datatable()//load danh sach de thi
    {
        // 
        if(Laratrust::can('exam_list_admin'))//xem tât cả đề thi
        {
            $exam = DB::table('exam')
                ->wherein('exam.status',[0,1,2,3,4])
                ->select( 'exam.id_exam','exam.type','exam.name','exam.status','exam.time_test','exam.number_question','exam.status','exam.created_at',);
            return DataTables::of($exam)
                    ->setRowId(function ($exam) {
                        return $exam->id_exam;
                    })
                    ->addColumn('id_exam', function ($exam) {
                        return '['.($exam->id_exam).']';
                    })

                    ->addColumn('created_at', function ($exam) {
                        return Helper::diffForHumans($exam->created_at);
                    })
                    ->addColumn('type', function ($exam) {
                        if($exam->type== 0)
                        {
                            return '<small class="badge badge-success">&nbsp&nbsp&nbsp&nbsp &nbsp Tất cả &nbsp&nbsp &nbsp &nbsp</small>';
                        }
                        if($exam->type== 1)
                        {
                            return '<small class="badge badge-warning">&nbsp&nbsp&nbsp Giới hạn &nbsp&nbsp&nbsp&nbsp &nbsp </small>';
                        }
                    })
                    ->addColumn('status', function ($exam) {
                        if($exam->status== 0)
                        {
                            return '<small class="badge badge-danger">&nbsp&nbsp&nbsp&nbsp &nbspĐã hủy &nbsp&nbsp &nbsp &nbsp</small>';
                        }
                        if($exam->status== 1)
                        {
                            return '<small class="badge badge-primary">&nbsp&nbsp&nbsp Chờ thi &nbsp&nbsp&nbsp&nbsp &nbsp </small>';
                        }
                        if($exam->status== 2)
                        {
                            return '<small class="badge badge-success">Chờ đến hạn</small>';
                        }
                        if($exam->status== 3)
                        {
                            return '<small class="badge badge-secondary">&nbsp&nbsp&nbsp&nbsp Hết hạn &nbsp&nbsp &nbsp </small>';
                        }
                    })

                    ->addColumn('action', function ($exam) {
                        return '
                        <span class="btn btn-outline-primary" onclick= delete_question('.$exam->id_exam.') id=""><i class="fas fa-allergies"></i></span>
                        <span class="btn btn-outline-success" onclick= delete_question('.$exam->id_exam.') id=""><i class="fa fa-edit"></i></span>
                        <span class="btn btn-outline-secondary "  id="" onclick="exam_user('.$exam->id_exam.')"><i class="fa fa-eye"></i></span>
                                                
                        <span class="btn btn-outline-danger" onclick= delete_question('.$exam->id_exam.') id=""><i class="fa fa-trash"></i></span>                           
                        ';
                    })
             ->rawColumns(['status','created_at','question_id','action','type'])
            ->toJson();
        }
        else
        {
            if(Laratrust::can('exam_list_user'))//xem de thi theo user login
            {
                $exam = DB::table('result_exam')
                ->join('exam','result_exam.id_exam','=','exam.id_exam',)
                ->where('result_exam.id_user','=',Auth::user()->id)
                ->wherein('result_exam.status',[0,3,4,5])
                ->select( 'exam.id_exam','result_exam.number_true','result_exam.id_result_exam','exam.name','exam.time_test','exam.number_question','result_exam.status','result_exam.created_at',);

            return DataTables::of($exam)
                    ->setRowId(function ($exam) {
                        return $exam->id_exam;
                    })
                    ->addColumn('id_exam', function ($exam) {
                        return '['.($exam->id_exam).']';
                    })

                    ->addColumn('created_at', function ($exam) {
                        return Helper::diffForHumans($exam->created_at);
                    })
                    ->addColumn('status', function ($exam) {
                        if($exam->status== 0)
                        {
                            return '<small class="badge badge-success">&nbsp&nbsp&nbsp&nbsp &nbsp Thi xong &nbsp&nbsp &nbsp &nbsp</small>';
                        }
                        if($exam->status== 3)
                        {
                            return '<small class="badge badge-danger">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp Bỏ thi &nbsp&nbsp&nbsp&nbsp &nbsp </small>';
                        }
                        if($exam->status== 4)
                        {
                            return '<small class="badge badge-danger">Hệ thống đóng</small>';
                        }
                        if($exam->status== 5)
                        {
                            return '<small class="badge badge-warning">Chờ chấm thi &nbsp&nbsp </small>';
                        }
                    })

                    ->addColumn('action', function ($exam) {
                        return '<a href="'.route("exam_export.detail",["id_result_exam"=>$exam->id_result_exam]).'" target="_blank">'
                        .'<span class="btn btn-outline-success"><i class="fas fa-download"></i></span>'
                        ;
                    })
             ->rawColumns(['status','created_at','question_id','action','type'])
            ->toJson();
            }
        }
        
    }
    public function handling_ajax_question_topic_datatable(Request $id_topic)
    {   
        
        $question_topic = DB::table('question')
                ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                ->where('topic.status',1)
                ->wherein('question.id_topic',$id_topic->id_topic)//$id_topic->id_topic
                ->where('question.status','=',1)
                ->select( 'question.id_question','topic.name','question.content','question.created_at');
        return DataTables::of($question_topic)
                ->setRowId(function ($question_topic) {
                    return $question_topic->id_question;
                })
                ->addColumn('check_box', function ($question_topic) {
                    return '<div class="icheck-success"><input onclick="select_id_question('.$question_topic->id_question.');" type="checkbox" class="txt_question_select" name="txt_question_select"  value="'.$question_topic->id_question.'"id="checkboxSuccess'.$question_topic->id_question.'"><label for="checkboxSuccess'.$question_topic->id_question.'">'.$question_topic->id_question.'</label></div>';
                })

                // ->addColumn('created_at', function ($load_trang_cau_hoi_theo_chu_de) {
                //     return Helper::diffForHumans($exam->created_at);
                // })
                // ->addColumn('type', function ($load_trang_cau_hoi_theo_chu_de) {
                //     if($load_trang_cau_hoi_theo_chu_de->type== 0)
                //     {
                //         return '<small class="badge badge-success">&nbsp&nbsp&nbsp&nbsp &nbsp Tất cả &nbsp&nbsp &nbsp &nbsp</small>';
                //     }
                //     if($load_trang_cau_hoi_theo_chu_de->type== 1)
                //     {
                //         return '<small class="badge badge-warning">&nbsp&nbsp&nbsp Giới hạn &nbsp&nbsp&nbsp&nbsp &nbsp </small>';
                //     }
                // })
                // ->addColumn('status', function ($load_trang_cau_hoi_theo_chu_de) {
                //     if($load_trang_cau_hoi_theo_chu_de->status== 0)
                //     {
                //         return '<small class="badge badge-danger">&nbsp&nbsp&nbsp&nbsp &nbspĐã hủy &nbsp&nbsp &nbsp &nbsp</small>';
                //     }
                //     if($load_trang_cau_hoi_theo_chu_de->status== 1)
                //     {
                //         return '<small class="badge badge-primary">&nbsp&nbsp&nbsp Chờ thi &nbsp&nbsp&nbsp&nbsp &nbsp </small>';
                //     }
                //     if($load_trang_cau_hoi_theo_chu_de->status== 2)
                //     {
                //         return '<small class="badge badge-success">Chờ đến hạn</small>';
                //     }
                //     if($load_trang_cau_hoi_theo_chu_de->status== 3)
                //     {
                //         return '<small class="badge badge-secondary">&nbsp&nbsp&nbsp&nbsp Hết hạn &nbsp&nbsp &nbsp </small>';
                //     }
                // })

                // ->addColumn('action', function ($load_trang_cau_hoi_theo_chu_de) {
                //     return '
                //     <span class="btn btn-outline-primary" onclick= delete_question('.$load_trang_cau_hoi_theo_chu_de->id_exam.') id=""><i class="fas fa-allergies"></i></span>
                //     <span class="btn btn-outline-success" onclick= delete_question('.$load_trang_cau_hoi_theo_chu_de->id_exam.') id=""><i class="fa fa-edit"></i></span>
                //     <span class="btn btn-outline-secondary "  id="" onclick="show_profile('.$load_trang_cau_hoi_theo_chu_de->id_exam.')"><i class="fa fa-eye"></i></span>
                                            
                //     <span class="btn btn-outline-danger" onclick= delete_question('.$load_trang_cau_hoi_theo_chu_de->id_exam.') id=""><i class="fa fa-trash"></i></span>                           
                //     ';
                // })
        ->rawColumns(['check_box'])
        ->toJson();
    }

    public function handling_ajax_question_topic_create(Request $request)//them de thi
    {
        if($request->handling='create')//tao de thi 
        {
           if($request->input('radio_question')==1)//tao cau hoi tu dong
           {                 
                $topic = explode(",", $request->id_topic);//jquery gui dang text có chua , "1,2" dùng ham cat dau , chuyen thanh mang
                $question = DB::table('question')
                        ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                        ->where('topic.status',1)
                        ->wherein('question.id_topic',($topic))//$id_topic->id_topic
                        ->where('question.status','=',1)
                        ->select( 'question.id_question')
                        ->get();
                // neu so luong cau hoi yeu cau nho hown hoac bawng so luongj cau hoi hej thong thi cho phep di tiep
                if($request->input('txt_number')<=count($question))//du cau hoi tao de tu dong
                {
                    $question = DB::table('question')
                        ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                        ->where('topic.status',1)
                        ->wherein('question.id_topic',($topic))//$id_topic->id_topic
                        ->where('question.status','=',1)
                        ->select( 'question.id_question')
                        ->orderByRaw('RAND()')//tao ngau nhien 
                        ->take($request->input('txt_number'))//so luong cau hoi lay ra
                        ->pluck('id_question');//chuyen thanh mang

                    $exam=new exam();
                    $exam->name=$request->input('txt_nam_exam');
                    $exam->type=0;
                    $exam->status=2;//chua den han để thi. hệ thống tự tính lúc nào được thi.
                    $exam->description=$request->input('txt_content');
                    $exam->number_question=$request->input('txt_number');                    
                    $exam->time_test=$request->input('txt_time_exam');
                    $exam->date_begin=$request->input('date_start');
                    $exam->save();

                    for($i=0;$i<count($question);$i++)
                    {
                        $exam_question=new exam_question();
                        $exam_question->id_exam=$exam->id;
                        $exam_question->id_question=$question[$i];
                        $exam_question->save();
                    }                    
                    return 'true';//tao cau hoi tu dong thanh cong
                }
                else
                {
                    return '-1';//khong du cau hoi de tao de
                }
                

           }
           else
           {
               if($request->input('radio_question')==2)//lua chọn câu hỏi bằng tay
               {
                    $topic = explode(",", $request->id_topic);//jquery gui dang text có chua , "1,2" dùng ham cat dau , chuyen thanh mang
                    $id_question = explode(",", $request->id_question);//jquery gui dang text có chua , "1,2" dùng ham cat dau , chuyen thanh mang

                    //nhan ma chu de, ma caau hoi
                    // neu so luogn cau hoi khong 

                    $question = DB::table('question')
                        ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                        ->where('topic.status',1)
                        ->wherein('question.id_topic',($topic))//$id_topic->id_topic
                        ->where('question.status','=',1)
                        ->select( 'question.id_question')
                        ->get();    
                    // neu so luong cau hoi yeu cau nho hown hoac bawng so luongj cau hoi hej thong thi cho phep di tiep    
                    if($request->input('txt_number')<=count($question))//du cau hoi tao de tu dong
                    {
                        $question_ = DB::table('question')
                            ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                            ->where('topic.status',1)
                            ->wherein('question.id_topic',($topic))//$id_topic->id_topic
                            ->wherein('id_question',($id_question))
                            ->where('question.status','=',1)
                            ->select( 'question.id_question')
                            ->orderByRaw('RAND()')//tao ngau nhien 
                            ->take($request->input('txt_number'))//so luong cau hoi lay ra
                            ->pluck('id_question');//chuyen thanh mang
                            
                        // khong co truong hop so cau duoc chon lon hon so cau yeu cau. vi da duoc ran buoc laij boi   ->take($request->input('txt_number'))
                        if(count($question_)==$request->input('txt_number'))//them tu dong
                        {   
                            $exam=new exam();
                            $exam->name=$request->input('txt_nam_exam');
                            $exam->type=0;
                            $exam->status=2;//chua den han để thi. hệ thống tự tính lúc nào được thi.
                            $exam->description=$request->input('txt_content');
                            $exam->number_question=$request->input('txt_number');                    
                            $exam->time_test=$request->input('txt_time_exam');
                            $exam->date_begin=$request->input('date_start');
                            $exam->save();
                            for($i=0;$i<count($question_);$i++)
                            {
                                $exam_question=new exam_question();
                                $exam_question->id_exam=$exam->id;
                                $exam_question->id_question=$question_[$i];
                                $exam_question->save();
                            }
                            return 'true';//thanhcong           
                        }
                        else//neu khong du he thong se tu them vao
                        {
                            
                            //return count($question);
                            if(count($question_)<$request->input('txt_number'))
                            {                                
                                $exam=new exam();
                                $exam->name=$request->input('txt_nam_exam');
                                $exam->type=0;
                                $exam->status=2;//chua den han để thi. hệ thống tự tính lúc nào được thi.
                                $exam->description=$request->input('txt_content');
                                $exam->number_question=$request->input('txt_number');                    
                                $exam->time_test=$request->input('txt_time_exam');
                                $exam->date_begin=$request->input('date_start');
                                $exam->save();

                                for($i=0;$i<count($question_);$i++)
                                {
                                    $exam_question=new exam_question();
                                    $exam_question->id_exam=$exam->id;
                                    $exam_question->id_question=$question_[$i];
                                    $exam_question->save();
                                }
                                
                                $question_sub = DB::table('question')
                                    ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                                    ->where('topic.status',1)
                                    ->wherein('question.id_topic',($topic))//$id_topic->id_topic
                                    ->whereNotIn('id_question',($id_question))
                                    ->where('question.status','=',1)
                                    ->select( 'question.id_question')
                                    ->orderByRaw('RAND()')//tao ngau nhien 
                                    ->take($request->input('txt_number')-count($question_))//so luong cau hoi lay ra
                                    ->pluck('id_question');//chuyen thanh mang
                                
                                for($i=0;$i<count($question_sub);$i++)
                                    {
                                        $exam_question=new exam_question();
                                        $exam_question->id_exam=$exam->id;
                                        $exam_question->id_question=$question_sub[$i];
                                        $exam_question->save();
                                    }                                
                                    return 'true';//thanhcong           
                            }         
                        }
                    }
                    else
                    {
                        return '-1';//so luong cau hoi khong du
                    }



               }
 
           }
        }

    }

    // load de thi len de thi theo ma de thi
    function exam_choose_test(Request $id_exam_test)
    {
        $exam_test=DB::table('exam')//lấy đề thi và load câu hỏi lên tạo ngẫu nhiên
                ->join('exam_question','exam.id_exam','=','exam_question.id_exam')
                ->join('question','exam_question.id_question','=','question.id_question')
                ->where('exam.status',1)
                ->where('exam.id_exam',$id_exam_test->id)//id la id de thi
                ->orderByRaw('RAND()')//tao ngau nhien 
                ->get(); 
        $question_option=DB::table('question_option') //lấy chi tiết câu trả lời
                ->join('exam_question','question_option.id_question','=','exam_question.id_question')
                ->where('exam_question.id_exam',$id_exam_test->id)
                ->get();           

        //tao kết quả thi

        //nếu kết quá thi có đề nào ở trạng thái đang thi 1 hoặc bỏ thi- hệ thống tự chốt 4 điều không được vào thi tiếp.
        $result_exam_user_0=DB::table('result_exam')//thi roi khong duoc thi nua
                    ->where('id_user',Auth::user()->id)
                    ->wherein('status',[0,5])
                    ->where('id_exam',$id_exam_test->id)
                    ->get();
        // dd($result_exam_user_0);
        if(count($result_exam_user_0)>0)
        {
            return 'thiroi';//đang thi nên không đươc vao thi tiếp.
        }

        $result_exam_user_1=DB::table('result_exam')
                    ->where('id_user',Auth::user()->id)
                    ->where('status',1)
                    ->get();        
 
        if(count($result_exam_user_1)>0)
        {
            return '-1';//đang thi nên không đươc vao thi tiếp.
        }

        $result_exam_user_4=DB::table('result_exam')
            ->where('id_user',Auth::user()->id)
            ->where('status',4)
            ->get();

        if(count($result_exam_user_4)>0)
        {
            return '-2';//hệ thống tự chốt nên bạn bị lock không được vao thi nữa.
        }

        $result_exam=new result_exam();
        $result_exam->id_user=Auth::user()->id;
        $result_exam->id_exam=$id_exam_test->id;
        $result_exam->status=1;
        $result_exam->number_true=0;
        $list_question='';
        // $id_result_exam=$result_exam->id;
        for ($i=0; $i <count($exam_test) ; $i++) 
        { 
            
            if($i+1==count($exam_test))
            {
                $list_question=$list_question.'{"id_question":'.$exam_test[$i]->id_question.'}';
            }
            else
            {
                $list_question=$list_question.'{"id_question":'.$exam_test[$i]->id_question.'},';
            }
        }
        $result_exam->id_question='['.($list_question).']';
        $result_exam->save(); 
         
        $data['exam']=$exam_test;
        $data2['question_option']=$question_option;
        return view('backend.thionline.exam.exam_test',$data,$data2)
                ->with('id_result_exam',$result_exam->id);       
    }

    function exam_update(Request $request)//nop de thi
    {
        $id_option=$request->id_option;//danh sach cau tra loi cua usser
        $result_exam=DB::table('result_exam')
                    ->where('id_result_exam',$request->id_result_exam)
                    ->where('id_user',Auth::user()->id)
                    ->where('status',1)
                    ->update(
                        [   
                            'id_option'=>$id_option,//update noi dung cau tl loi cua usser vao db
                        ]
                    );        
        $question_user=DB::table('result_exam')
                    ->where('id_result_exam',$request->id_result_exam)
                    ->where('id_user',Auth::user()->id)  
                    ->select('id_question','id_option')                  
                    ->first();

        $result_exam_user_option = json_decode($question_user->id_option,true);
        $result_exam_user_question = json_decode($question_user->id_question,true);  
        $list_id_question=[];
        $list_id_option=[];//danh sacsh cau chon cua usser
        for($i=0;$i<count($result_exam_user_option);$i++)
        {
            array_push($list_id_option,$result_exam_user_option[$i]['id_option']);          
        }

        for($i=0;$i<count($result_exam_user_question);$i++)
        {
            array_push($list_id_question,$result_exam_user_question[$i]['id_question']);          
        }
        //danh sach cau hoi cua he thong
        $question_system=DB::table('question')
                ->wherein('question.id_question',$list_id_question)
                ->select('id_question','type')
                ->get();
        $question_system_option_true=DB::table('question_option')
                    ->wherein('question_option.id_question',$list_id_question)
                    ->where('question_option.true',1)
                    ->select('id_question_option')
                    ->pluck('id_question_option');
        $number_true=count($question_system);
        $status=0;
        foreach($question_system as $qs)
        {
            if($qs->type==3)
            {            
                $result_exception =new result_exception();
                $result_exception->id_result_exam=$request->id_result_exam;
                $result_exception->id_question=$qs->id_question;
                $result_exception->content=$request->input($qs->id_question);
                $result_exception->save();
                $number_true=$number_true-1;
                $status=5;
            }            
        }

        $fail_option=[];
        for ($i=0; $i <count($question_system_option_true) ; $i++) { 
            $temp=0;
            for ($j=0; $j <count($list_id_option) ; $j++) 
            {               
                if($question_system_option_true[$i]==$list_id_option[$j])
                {
                    $temp=$temp+1;   
                }
            }
            if($temp==0)
            {
                array_push($fail_option,$question_system_option_true[$i]);          
            }
        }        
        $question_system_fail=DB::table('question_option')
                ->wherein('question_option.id_question_option',$fail_option)
                ->select('id_question')
                ->distinct()
                ->get();
                
        $number_true=$number_true-count($question_system_fail);
        $result_exam2=DB::table('result_exam')
                ->where('id_result_exam',$request->id_result_exam)
                ->where('id_user',Auth::user()->id)
                ->where('status',1)
                ->update(
                    [
                        'number_true'=>$number_true,
                        'status'=>$status,
                        'updated_at'=>Carbon::now()
                    ]
                );
        
        return view('backend.thionline.exam.exam_result')
                ->with('list_option',$question_system_option_true)
                ->with('number_true',$number_true);
    }

    function hadding_exam(Request $requests)//load bang tong hop ng vao thi 1 de thi, 
    {
        switch ($requests->hadding)
        {
            case 'load_exam_user'://load bang tong hop danh sach nguowi da vao thi 1 de thi
                    $result_exam=DB::table('result_exam')
                                    ->join('users','result_exam.id_user','=','users.id')
                                    ->where('result_exam.id_exam',$requests->id_exam)
                                    ->select('result_exam.id_result_exam','result_exam.status','result_exam.number_true','users.name')
                                    ->get();
                    return view('backend.thionline.exam.exam_exam_user')
                            ->with('result_exam',$result_exam)
                            ->with('id_exam',$requests->id_exam);
                break;
            
            default:
                # code...
                break;
        }
    }
    public function export_exam(Request $requests)//xuat danh sach đề đã thi 1 đê có nhiều ng thi.
    {
        // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        // $section = $phpWord->addSection();
        // $section->addText(
        //     '"Learn from yesterday, live for today, hope for tomorrow. '
        //         . 'The important thing is not to stop questioning." '
        //         . '(Albert Einstein)'
        // );
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save(storage_path('helloWorld.docx'));//luu vao public

        // return response()->download(storage_path('helloWorld.docx'));
        
        


        $exam=DB::table('exam')->where('id_exam',$requests->id_exam)->first();

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('adminlte/template/ketquathi.docx');
        // $templateProcessor->setValue(
        // ['city', 'street'],['Sunnydale, 54321 Wisconsin', '123 International Lane']);
        $templateProcessor->setValue('exam_name',$exam->name);
        $templateProcessor->setValue('date_begin',$exam->date_begin);
        $templateProcessor->setValue('number_question',$exam->number_question);
        $templateProcessor->setValue('time_test',$exam->time_test);
        
        $result_exam=DB::table('result_exam')
                ->join('users','result_exam.id_user','=','users.id')
                ->where('result_exam.id_exam',$requests->id_exam)
                ->select('result_exam.id_exam','result_exam.status','result_exam.number_true','users.name')
                ->get();
        
        // dd($result_exam);     
        // $values = [
        //     ['userId' => 1, 'userName' => 'Batman', 'userAddress' => 'Gotham City'],
        //     ['userId' => 2, 'userName' => 'Superman', 'userAddress' => 'Metropolis'],
        // ];
        $values=[];
        // $templateProcessor->cloneRow('id_exam',count($result_exam));
        
        // $values = $result_exam;
        $i=1;
        foreach($result_exam as $re_ex)
        {   
            $status='';
            if($re_ex->status==0)
            {
                $status='Đã thi xong';
            }
            if($re_ex->status==1)
            {
                $status='Đang thi';
            }
            if($re_ex->status==3)
            {
                $status='Bỏ thi';
            }
            if($re_ex->status==5)
            {
                $status='Chờ chấm thi';
            }

            $item=[
                'stt'  =>$i,
                'name' =>$re_ex->name,
                'status' =>$status,
                'number_true'=>$re_ex->number_true
            ];
            array_push($values,$item);  
            $i++;
        }
        try {
            $templateProcessor->cloneRowAndSetValues('name', $values);
            $templateProcessor->saveAs('temp/Ketquathi.docx');
            return response()->download(('temp/Ketquathi.docx'));
            
        } 
        catch (Exception $e)
        {
        }
    }
    public function export_exam_detail(Request $requests)//xuat danh sach đề đã thi 1 đê có nhiều ng thi.
    {
        if(Laratrust::can('exam_list_admin'))//xem tât cả đề thi
        {
            $id_result_exam=$requests->id_result_exam;
            $exam=DB::table('exam')
                    ->join('result_exam','exam.id_exam','=','result_exam.id_exam')
                    ->join('users','result_exam.id_user','=','users.id')
                    ->where('result_exam.id_result_exam',$requests->id_result_exam)
                    ->select('result_exam.id_result_exam','result_exam.id_option','result_exam.id_question','result_exam.created_at as date_time_test','result_exam.number_true','exam.name as name_exam', 'exam.id_exam','exam.number_question','exam.time_test','users.name as name_user')
                    ->first();

            $id_question = json_decode($exam->id_question,true);
            $id_option = json_decode($exam->id_option,true);

            $list_id_question=[];
            $list_id_option=[];//danh sacsh cau chon cua usser
            for($i=0;$i<count($id_question);$i++)
            {
                array_push($list_id_question,$id_question[$i]['id_question']);          
            }

            for($i=0;$i<count($id_option);$i++)
            {
                array_push($list_id_option,$id_option[$i]['id_option']);          
            }

            $question=DB::table('question')
                        ->wherein('question.id_question',$list_id_question)
                        ->get();

            $question_option=DB::table('question_option')
                        ->wherein('question_option.id_question',$list_id_question)
                        ->get();

            $result_exception=DB::table('result_exception')
                        ->wherein('id_question',$list_id_question)     
                        ->get();  
            
            
            return view('backend.thionline.exam.exam_exam_user_detail')
                        ->with('exam',$exam)
                        ->with('question',$question)
                        ->with('question_option',$question_option)
                        ->with('result_exception',$result_exception)
                        ->with('list_id_option',$list_id_option)
                        ->with('list_id_question',$list_id_question);
        }
        else
        {
            if(Laratrust::can('exam_list_user'))//xem de thi theo user login
            {

                $id_result_exam=$requests->id_result_exam;
                $exam=DB::table('exam')
                        ->join('result_exam','exam.id_exam','=','result_exam.id_exam')
                        ->join('users','result_exam.id_user','=','users.id')
                        ->where('result_exam.id_result_exam',$requests->id_result_exam)
                        ->select('result_exam.id_result_exam','result_exam.id_option','result_exam.id_question','result_exam.created_at as date_time_test','result_exam.number_true','exam.name as name_exam', 'exam.id_exam','exam.number_question','exam.time_test','users.name as name_user','users.id')
                        ->first();
                if($exam->id<>Auth::user()->id)
                {
                    return redirect()->route('home');
                }
                else
                {
                        $id_question = json_decode($exam->id_question,true);
                        $id_option = json_decode($exam->id_option,true);
            
                        $list_id_question=[];
                        $list_id_option=[];//danh sacsh cau chon cua usser
                        for($i=0;$i<count($id_question);$i++)
                        {
                            array_push($list_id_question,$id_question[$i]['id_question']);          
                        }
            
                        for($i=0;$i<count($id_option);$i++)
                        {
                            array_push($list_id_option,$id_option[$i]['id_option']);          
                        }
            
                        $question=DB::table('question')
                                    ->wherein('question.id_question',$list_id_question)
                                    ->get();
            
                        $question_option=DB::table('question_option')
                                    ->wherein('question_option.id_question',$list_id_question)
                                    ->get();
            
                        $result_exception=DB::table('result_exception')
                                    ->wherein('id_question',$list_id_question)     
                                    ->get();  
                        
                        
                        return view('backend.thionline.exam.exam_exam_user_detail')
                                    ->with('exam',$exam)
                                    ->with('question',$question)
                                    ->with('question_option',$question_option)
                                    ->with('result_exception',$result_exception)
                                    ->with('list_id_option',$list_id_option)
                                    ->with('list_id_question',$list_id_question);
                }
                
            }
        }
        
    }
}
