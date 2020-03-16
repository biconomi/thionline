<?php

namespace App\Http\Controllers\thionline\question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Helper;
use Auth;
use Laratrust;
use DB;
use Carbon\Carbon;
use App\question;
use App\question_option;
class questionController extends Controller
{

    public function question_list()
    {
        if(Laratrust::can('permission-name'))
        {
           
        }
        $data['question']=DB::table('topic')->get();
        return view('backend.thionline.question.question_list',$data);  
    }
    public function question_store(Request $question_resuest)
    {
        if($question_resuest->handling=='create')
        {   
            if($question_resuest->input('type_question')==1)//cau hoi 1 lựa chọn đúng.
            {
                $question =new question();
                $question->content=trim($question_resuest->input('txt_content'));

                $question->id_topic=$question_resuest->input('txt_topic');
                $question->status=1;
                $question->type=1;
                $question->save();
            
                for($i=1;$i<=$question_resuest->input('txt_number_answer');$i++)
                {
                    $checkbox_match= $question_resuest->input('txt_ansser'); 
                    $question_option =new question_option();
                    $question_option->id_question=$question->id;

                    $question_option->content_option=trim($question_resuest->input('input_ansser'.$i));
                    for ($j=1;$j<=count($checkbox_match);$j++) 
                    {    

                        if($checkbox_match[$j-1]==$i)
                        {       
                            $question_option->true=1;
                            break;
                        }
                        else
                        {
                            $question_option->true=0;
                        }
                    }
                    $question_option->save(); 
                }
                return 'true';
            }
            else
            {
                if($question_resuest->input('type_question')==2)//lua chon nhieu cau dung
                {
                    $question =new question();
                    $question->content=trim($question_resuest->input('txt_content'));
                    $question->id_topic=$question_resuest->input('txt_topic');
                    $question->status=1;
                    $question->type=2;
                    $question->save();
                                
                    for($i=1;$i<=$question_resuest->input('txt_number_answer');$i++)
                    {
                        $checkbox_match= $question_resuest->input('txt_ansser_checkbox'); 
                        $question_option =new question_option();
                        $question_option->id_question=$question->id;

                        $question_option->content_option=trim($question_resuest->input('input_ansser_check'.$i));

                        for ($j=1;$j<=count($checkbox_match);$j++) 
                        {    

                            if($checkbox_match[$j-1]==$i)
                            {       
                                $question_option->true=1;
                                break;
                            }
                            else
                            {
                                $question_option->true=0;
                            }
                        }
                        $question_option->save(); 
                    }
                    return 'true';
                }
                else//cau hoi nhap lieu
                {
                    $question =new question();
                    $question->content=$question_resuest->input('txt_content');
                    $question->id_topic=$question_resuest->input('txt_topic');
                    $question->status=1;
                    $question->type=3;
                    $question->save();                    
                    return 'true';
                }
            }
            
        }
        else
        {
            if($question_resuest->handling=='updete')
            {
                
            }
            else//delete chuyên trang thai cau hoi khong hien nưa
            {
                $question=question::where('id_question',$question_resuest->id_question)
                                ->update(['status' => 2]);
                return 'true';
            }

        }
        
        return 'false';

    }






    public function handling_ajax_question()
    {        
        $question = DB::table('question')
                ->join('topic', 'question.id_topic', '=', 'topic.id_topic')
                ->where('question.status',1)
                ->select( 'topic.id_topic','topic.name','question.id_question','question.content','question.status','question.created_at',);

            return DataTables::of($question)
                    ->setRowId(function ($question) {
                        return $question->id_question;
                    })

                    ->addColumn('question_id', function ($question) {
                        return '['.($question->id_question).']';
                    })

                    ->addColumn('created_at', function ($question) {
                        return Helper::diffForHumans($question->created_at);
                    })
                    ->addColumn('status', function ($question) {
                        return $question->status== 1 ? '<small class="badge badge-success">Enabled</small>' : '<small class="badge badge-danger">Disabled</small>';
                    })

                    ->addColumn('action', function ($question) {
                        return '
                        <span class="btn btn-outline-primary"  id="" onclick="show_profile('.$question->id_question.')"><i class="fa fa-eye"></i></i></span>
                        <span class="btn btn-outline-warning" onclick= delete_question('.$question->id_question.') id=""><i class="fa fa-trash"></i></span>                        
                        ';
                    })
             ->rawColumns(['action','status','created_at','question_id'])
            ->toJson();
    }
}
