<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class routeController extends Controller
{
    //
    public function filter(Request $request)
    {
        $filters = $request->input('filters');

        $query = Car::query();

        $query->where(function ($q) use ($filters) {
            if (!empty($filters['model'])) {
                $q->orWhereIn('model', $filters['model']);
            }

            if (!empty($filters['car_condition'])) {
                $q->orWhereIn('car_condition', $filters['car_condition']);
            }

            if (!empty($filters['colors'])) {
                $q->orWhereIn('car_color', $filters['colors']);
            }

            if (!empty($filters['body_type'])) {
                $q->orWhereIn('body_type', $filters['body_type']);
            }
        });

        $cars = $query->limit(8)->get();

        return response()->json([
            'cars' => $cars
        ]);
    }
    public function default()
    {
        $cars = Car::latest()->take(8)->get(); // or use ->where('is_featured', true)
        return response()->json(['cars' => $cars]);
    }
    public function home(){
        return view("home.index");
    }
}
