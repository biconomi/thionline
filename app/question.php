<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $table = 'question';
    protected $fillable = [
        'id_question', 'content', 'status','id_topic','created_at','updated_at'
    ];
    
    public $timestamps = true;
}
