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
        return view('car.car-listing');
    }

    /**
     * Filter the cars.
     */
   public function filter(Request $request)
    {
        $query = Car::query();

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('model', 'like', "%$keyword%")
                ->orWhere('year', 'like', "%$keyword%")
                ->orWhere('color', 'like', "%$keyword%")
                ->orWhere('transmission_type', 'like', "%$keyword%");
            });
        }

        if ($years = $request->input('Year', [])) {
            $query->whereIn('year', $years);
        }

        if ($models = $request->input('Model', [])) {
            $query->whereIn('model', $models);
        }

        if ($transmission = $request->input('Transmission', [])) {
            $query->whereIn('transmission_type', $transmission);
        }

        if ($bodies = $request->input('Body', [])) {
            $query->whereIn('body_type', $bodies);
        }

        if ($colors = $request->input('Color', [])) {
            $query->whereIn('color', $colors);
        }
        // Handle sorting
        switch ($request->input('sort')) {
            case 'name':
                $query->orderBy('model');
                break;
            case 'price':
                $query->orderBy('sale_price');
                break;
            case 'date':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest(); // Default sort
        }
        $cars = $query->get();

        return response()->json($cars);
    }



}
