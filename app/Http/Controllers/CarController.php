<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use App\Enums\CarColor;

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

    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        return view('car.register');
    }
 public function store(StoreCarRequest $request)
    {
        $data = $request->validated();

        // Just save the car_color string from input (no enum)
        $data['car_color'] = $request->car_color;
        $data['car_condition'] = $request->car_condition;
        $data['transmission_type'] = $request->transmission_type;
        $data['car_documents'] = $request->car_documents;
        $data['car_inside_color'] = $request->car_inside_color;
        $data['VIN_number'] = strtoupper(bin2hex(random_bytes(8))); // Generate a random VIN number
        $data['regular_price'] = $request->regular_price;
        $data['sale_price'] = $request->sale_price;
        $dara['title'] = $request->title;
        $data['year'] = $request->year;
        $data['make'] = $request->make;
        $data['body_type'] = $request->body_type;
        $data['model'] = $request->model;
        $dara['description'] = $request->description;
        $data['currency_type'] = $request->currency_type;
        $data['model'] = $request->model;



        // Images
        $data['images'] = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $data['images'][] = $image->store('images/car/images', 'public');
            }
        }

        // Videos
        $data['videos'] = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $data['videos'][] = $video->store('images/car/videos', 'public');
            }
        }

        // Location: ensure array type
        if (is_string($request->location)) {
            $data['location'] = explode(',', $request->location);
        } elseif (is_array($request->location)) {
            $data['location'] = $request->location;
        }

        Car::create($data);

        return redirect()->route('car.index')->with('success', 'Car registered successfully!');
    }



}

