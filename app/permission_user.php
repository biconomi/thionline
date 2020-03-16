<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class permission_user extends Model
{
    //
    protected $table = 'permission_user';
    protected $fillable = [
        'permission_id', 'user_id', 'user_type'
    ];
    
    public $timestamps = false;
}
