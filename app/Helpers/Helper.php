<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\user;
class Helper extends Controller
{
    public static $user_get=null;
    
    public function __construct() {
        $this->user_get='';
    }
    public static function diffForHumans($date)
    {
        return \Carbon\Carbon::parse($date)->diffForHumans();
    }
    public static function demo ()
    {
        return static::$user_get;
    }

    public static function getUserlogin($id)
    {
       return static::$user_get=user::find($id);
    }

}