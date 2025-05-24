<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    
    /**
     * Display the car index.
     */
    public function index()
    {
        $cars = Car::all();
        return view('car.index', compact('cars'));
    }

}
