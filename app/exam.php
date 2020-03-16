<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam extends Model
{
    //
    protected $table = 'exam';
    protected $fillable = [
        'id_exam', 'name', 'status','number_question','date_begin','date_end','created_at','updated_at'
    ];
    
    public $timestamps = true;
}
