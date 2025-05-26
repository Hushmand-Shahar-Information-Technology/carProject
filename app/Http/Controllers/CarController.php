<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;

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
    try {
    // Handle multiple image uploads
    $images = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $images[] = $image->store('cars/images', 'public');
        }
    }

    // Handle multiple video uploads
    $videos = [];
    if ($request->hasFile('videos')) {
        foreach ($request->file('videos') as $video) {
            $videos[] = $video->store('cars/videos', 'public');
        }
    }

    Car::create([
        'title' => $data['title'],
        'year' => $data['year'],
        'make' => $data['make'],
        'VIN_number' => $data['VIN_number'] ?? null,
        'location' => isset($data['location']) ? json_encode($data['location']) : null,
        'model' => $data['model'],
        'color' => $data['color'],
        'transmission_type' => $data['transmission_type'] ?? null,
        'regular_price' => $data['regular_price'] ?? null,
        'currency_type' => $data['currency_type'] ?? null,
        'sale_price' => $data['sale_price'] ?? null,
        'request_price_status' => $request->boolean('request_price_status'),
        'request_price' => $data['request_price'] ?? null,
        'images' => !empty($images) ? json_encode($images) : null,
        'video' => !empty($videos) ? json_encode($videos) : null,
    ]);

    return redirect()->route('car.index')
        ->with('success', 'Car created successfully.');
        //code...
    } catch (\Throwable $th) {
        dd("error");
    }
}


}

