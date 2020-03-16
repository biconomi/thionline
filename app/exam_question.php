<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam_question extends Model
{
        //
        protected $table = 'exam_question';
        protected $fillable = [
            'id', 'id_exam', 'id_question'
        ];
        
        public $timestamps = false;
}
