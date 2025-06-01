<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class routeController extends Controller
{
    //
    public function home(){
        $distinctValues = [
            'colors' => DB::table('cars')->whereNotNull('car_color')->distinct()->pluck('car_color'),
            'models' => DB::table('cars')->whereNotNull('model')->distinct()->pluck('model'),
            'make' => DB::table('cars')->whereNotNull('make')->distinct()->pluck('make'),
            'body_type' => DB::table('cars')->whereNotNull('body_type')->distinct()->pluck('body_type'),
            'car_condition' => DB::table('cars')->whereNotNull('car_condition')->distinct()->pluck('car_condition'),
        ];
        return view("home.index", compact('distinctValues'));
    }
}
