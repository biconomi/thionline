<?php

namespace App\Http\Controllers\thionline\dashbroad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class dashbroadController extends Controller
{
    public function index()
    {       
        return view('backend.thionline.dashbroad.dashbroad');  
    }
}
