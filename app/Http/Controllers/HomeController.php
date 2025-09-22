<?php

namespace App\Http\Controllers;

use App\Models\Bargain;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Promotion;

class HomeController extends Controller
{
    public function index()
    {
        $latestCars = $this->getLatestCars();
        $latestBargains = $this->getLatestBargains();
        $promotedCars = $this->getPromotedItems('car');
        $promotedBargains = $this->getPromotedItems('bargain');
        // dd($promotedBargains);
        return view('home.index', compact('latestBargains', 'promotedCars', 'latestCars', 'promotedBargains'));
    }

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

    public function getPromotedCars()
    {
        $promotedCars = Car::whereHas('promotions', function ($query) {
            $query->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            });
        })
        ->with(['promotions' => function ($query) {
            $query->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })->latest('ends_at');
        }])
        ->orderByDesc('id')
        ->take(6)
        ->get();

        return $promotedCars;
    }

    public function getPromotedItems($type)
    {
        $model = match(strtolower($type)) {
            'car' => Car::class,
            'bargain' => \App\Models\Bargain::class,
            default => throw new \InvalidArgumentException("Invalid type: $type")
        };

        return $model::whereHas('promotions', fn($q) => $q->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>', now())))
            ->with(['promotions' => fn($q) => $q->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>', now()))->latest('ends_at')])
            ->latest('id')
            ->take(15)
            ->get();
    }
    public function getLatestBargains()
        {
            $latestbargains = Bargain::orderByDesc('id')
                ->take(10)
                ->get();

            return $latestbargains;
        }

    public function getLatestCars()
    {
        $latestCars = Car::orderByDesc('id')
            ->take(10)
            ->get();

        return $latestCars;
    }
}
