<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class result_exam extends Model
{
    protected $table = 'result_exam';
    protected $fillable = [
        'id_result_exam', 'id_user', 'id_exam','id_question','id_option','status','number_true','created_at','updated_at'
    ];
    
    public $timestamps = true;
}
