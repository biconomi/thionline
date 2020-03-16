<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class result_exception extends Model
{
    protected $table = 'result_exception';
    protected $fillable = [
        'id_result_exception', 'id_result_exam', 'id_question','content','true'
    ];
    
    public $timestamps = false;
}
