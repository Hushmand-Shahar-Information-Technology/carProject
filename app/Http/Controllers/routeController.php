<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class routeController extends Controller
{
    //
    public function home(){
        return view("home.index");
    }
}
