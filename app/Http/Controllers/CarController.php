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
        return view('car.car-listing', compact('cars'));
    }

    /**
     * Filter the cars.
     */
   public function filter(Request $request)
    {
        $cars = Car::query();

        if ($request->filled('year')) {
            $cars->whereIn('year', $request->year);
        }
        if ($request->filled('condition')) {
            $cars->whereIn('condition', $request->condition);
        }
        if ($request->filled('model')) {
            $cars->whereIn('model', $request->model);
        }
        // ... Add more filters as needed ...

        $filteredCars = $cars->latest()->get();

        if ($request->ajax()) {
            return view('car.car-results', compact('filteredCars'))->render();
        }
        
    }


}
