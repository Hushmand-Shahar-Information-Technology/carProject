<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Support\Facades\Log;


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

        $cars = Car::query();

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('model', 'like', "%$keyword%")
                    ->orWhere('year', 'like', "%$keyword%")
                    ->orWhere('car_color', 'like', "%$keyword%")
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
            $query->whereIn('car_color', $colors);
        }
        // Handle sorting
        $sort = $request->input('sort');
        // dd($sort);
        // dd($sort);
        if ($sort === 'name') {
            $query->whereNotNull('model')->orderBy('model');
        } elseif ($sort === 'price') {
            $query->whereNotNull('sale_price')->orderBy('sale_price');
        } elseif ($sort === 'date') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->latest(); // Default sort
        }

        $cars = $query->get();

        return response()->json($cars);
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
            Log::info('Car store method started');

            // Handle image uploads
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $images[] = str_replace('public/', '', $image->store('images/car', 'public'));
                }
            }

            // Handle video uploads
            $videos = [];
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $videos[] = str_replace('public/', '', $video->store('videos/car', 'public'));
                }
            }

            Car::create([
                'title' => $data['title'],
                'year' => $data['year'],
                'make' => $data['make'],
                'VIN_number' => $data['VIN_number'] ?? null,
                'location' => isset($data['location']) ? json_encode($data['location']) : null,
                'model' => $data['model'],
                'car_color' => $data['car_color'],
                'transmission_type' => $data['transmission_type'] ?? null,
                'regular_price' => $data['regular_price'] ?? null,
                'body_type' => $data['body_type'] ?? null,
                'car_condition' => $data['car_condition'] ?? null,
                'car_documents' => $data['car_documents'] ?? null,
                'car_inside_color' => $data['car_inside_color'] ?? null,
                'currency_type' => $data['currency_type'] ?? null,
                'sale_price' => $data['sale_price'] ?? null,
                'request_price_status' => $request->boolean('request_price_status'),
                'request_price' => $data['request_price'] ?? null,
                'images' => $images, // saved as actual array (use JSON column in DB)
                'video' => $videos,  // same for videos
            ]);

            return redirect()->route('car.index')->with('success', 'Car created successfully.');
        } catch (\Throwable $th) {
            Log::error('Error storing car: ' . $th->getMessage());
            // return back()->withErrors('Something went wrong while saving the car.');
            dd($th->getMessage());

        }
    }


    /**
     * Show the form for creating a new car.
     */
    public function show($id)
    {
        $car = Car::findOrFail($id); 
        // dd($car->location);
        return view('car.show', compact('car'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $cars = Car::where('model', 'like', "%$keyword%")->get();
        return response()->json($cars);
    }
    /**
     * Feature for the new cars.
     */
    public function feature()
    {
        $cars = Car::orderBy('id', 'desc')->take(15)->get(); 
        return response()->json($cars);
    }
}
