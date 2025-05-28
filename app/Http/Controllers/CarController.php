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
        $sort = $request->input('sort');
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
