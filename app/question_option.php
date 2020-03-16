<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question_option extends Model
{
    protected $table = 'question_option';
    protected $fillable = [
        'id_question_option', 'id_question', 'content_option','true'
    ];
    public $timestamps = false;
}
