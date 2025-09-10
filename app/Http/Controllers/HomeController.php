<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class HomeController extends Controller
{
    public function filter(Request $request)
    {
        $filters = $request->input('filters', []);

        $bodyTypes = $filters['body_type'] ?? [];
        $carConditions = $filters['car_condition'] ?? [];
        $colors = $filters['colors'] ?? [];
        $models = $filters['model'] ?? [];

        $cars = Car::query()
            ->where(function ($query) use ($bodyTypes, $carConditions, $colors, $models) {
                if (!empty($bodyTypes)) {
                    $query->orWhereIn('body_type', $bodyTypes);
                }
                if (!empty($carConditions)) {
                    $query->orWhereIn('car_condition', $carConditions);
                }
                if (!empty($colors)) {
                    $query->orWhereIn('car_color', $colors);
                }
                if (!empty($models)) {
                    $query->orWhereIn('model', $models);
                }
            })
            ->orderByDesc('id') // last inserted cars
            ->take(8)
            ->get();

        return response()->json(['cars' => $cars]);
    }
    public function default()
    {
        $cars = Car::query()
            ->orderByDesc('id') // last inserted cars
            ->take(8)
            ->get();

        return response()->json(['cars' => $cars]);
    }
}
