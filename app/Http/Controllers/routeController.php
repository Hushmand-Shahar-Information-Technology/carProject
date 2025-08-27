<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class routeController extends Controller
{
    //
    public function home(){
        return view("home.index");
    }
}
