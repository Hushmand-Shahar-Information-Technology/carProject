<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Support\Facades\DB;
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
        $cars = Car::query()
            ->when($request->input('keyword'), function ($q, $keyword) {
                $q->where(function ($q2) use ($keyword) {
                    $q2->where('model', 'like', "%$keyword%")
                        ->orWhere('year', 'like', "%$keyword%")
                        ->orWhere('car_color', 'like', "%$keyword%")
                        ->orWhere('make', 'like', "%$keyword%")
                        ->orWhere('car_condition', 'like', "%$keyword%")
                        ->orWhere('transmission_type', 'like', "%$keyword%");
                });
            })
            ->when($request->input('year_min') && $request->input('year_max'), function ($q) use ($request) {
                $q->whereBetween('year', [$request->input('year_min'), $request->input('year_max')]);
            })
            ->when($request->input('Year', []), function ($q, $years) {
                $q->whereIn('year', $years);
            })
            ->when($request->input('Make', []), function ($q, $models) {
                $q->whereIn('make', $models);
            })
            ->when($request->input('Model', []), function ($q, $models) {
                $q->whereIn('model', $models);
            })
            ->when($request->input('Transmission', []), function ($q, $transmissions) {
                $q->whereIn('transmission_type', $transmissions);
            })
            ->when($request->input('Body', []), function ($q, $bodies) {
                $q->whereIn('body_type', $bodies);
            })
            ->when($request->input('Color', []), function ($q, $colors) {
                $q->whereIn('car_color', $colors);
            })
            ->when($request->input('Condition', []), function ($q, $condition) {
                $q->whereIn('car_condition', $condition);
            })
            ->when($request->input('sort'), function ($q, $sort) {
                match ($sort) {
                    'name' => $q->whereNotNull('model')->orderBy('model'),
                    'price' => $q->whereNotNull('sale_price')->orderBy('sale_price'),
                    'date' => $q->orderByDesc('created_at'),
                    default => $q->latest(),
                };
            }, function ($q) {
                $q->latest();
            })
            ->get();

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
        $makes = Car::where('make', $car->make)->limit(10)->get();
        return view('car.show', compact('car', 'makes'));
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


    public function CarDirectory()
    {
        // Define logos and their corresponding car makes
        $logos = [
            ['image' => '01.png', 'make' => 'Toyota'],
            ['image' => '02.png', 'make' => 'BMW'],
            ['image' => '03.png', 'make' => 'Honda'],
            ['image' => '04.png', 'make' => 'Ford'],
            ['image' => '05.png', 'make' => 'Hyundai'],
            ['image' => '06.png', 'make' => 'Nissan'],
            ['image' => '07.png', 'make' => 'Kia'],
            ['image' => '08.png', 'make' => 'Mercedes'],
        ];

        // Add dynamic count to each
        foreach ($logos as &$logo) {
            $logo['count'] = Car::where('make', $logo['make'])->count();
        }

        return view('car.directory', compact('logos'));
    }

    public function cart(Request $request)
    {
        $make = $request->input('make'); // or $request->make
        $cars = Car::where('make', $make)->limit(10)->get();
        return response()->json(['cars' => $cars]);
    }
}
