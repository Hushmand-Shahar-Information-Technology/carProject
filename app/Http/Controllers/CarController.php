<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Bargain;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{

    /**
     * Display the car index.
     */
    public function index()
    {
        return view('car.car-listing');
    }

    public function compare()
    {
        return view('car.compare');
    }

    /**
     * Get car details by IDs for comparison
     */
    public function getCarDetails(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return response()->json([]);
        }

        $carIds = explode(',', $ids);
        $cars = Car::whereIn('id', $carIds)->get();

        return response()->json($cars);
    }

    /**
     * Filter the cars.
     */
    public function filter(Request $request)
    {
        $cars = Car::query()
            ->with('bargain')
            ->where('is_for_rent', '!=', 1)
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
            ->when($request->input('price_min') && $request->input('price_max'), function ($q) use ($request) {
                $q->whereBetween('regular_price', [$request->input('price_min'), $request->input('price_max')]);
            })
            ->when($request->query('Year', []), function ($q, $years) {
                $q->whereIn('year', $years);
            })
            ->when($request->query('Make', []), function ($q, $makes) {
                $q->whereIn('make', $makes);
            })
            ->when($request->query('Model', []), function ($q, $models) {
                $q->whereIn('model', $models);
            })
            ->when($request->query('Transmission', []), function ($q, $transmissions) {
                $q->whereIn('transmission_type', $transmissions);
            })
            ->when($request->query('Body', []), function ($q, $bodies) {
                $q->whereIn('body_type', $bodies);
            })
            ->when($request->query('Color', []), function ($q, $colors) {
                $q->whereIn('car_color', $colors);
            })
            ->when($request->query('Condition', []), function ($q, $conditions) {
                $q->whereIn('car_condition', $conditions);
            })

            ->when($request->input('sort'), function ($q, $sort) {
                match ($sort) {
                    'name' => $q->whereNotNull('model')->orderBy('model'),
                    'price' => $q->whereNotNull('regular_price')->orderBy('regular_price'),
                    'date' => $q->orderByDesc('created_at'),
                    default => $q->latest(),
                };
            }, function ($q) {
                $q->latest();
            })
            ->paginate(15)
            ->withQueryString();

        return response()->json($cars);
    }

    /**
     * Display rent-only car index page (same UI as listing).
     */
    public function rentIndex()
    {
        return view('car.rent-listing');
    }

    /**
     * Filter only cars available for rent with pagination (12 per page).
     */
    public function filterRent(Request $request)
    {
        $perPage = (int) ($request->integer('per_page') ?: 12);

        $cars = Car::query()
            ->where('is_for_rent', true)
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
            ->when($request->input('price_min') && $request->input('price_max'), function ($q) use ($request) {
                // Use rent price if present; fall back to regular_price for range filtering compatibility
                $q->where(function ($sub) use ($request) {
                    $sub->whereBetween('rent_price_per_day', [$request->input('price_min'), $request->input('price_max')])
                        ->orWhereBetween('rent_price_per_month', [$request->input('price_min'), $request->input('price_max')])
                        ->orWhereBetween('regular_price', [$request->input('price_min'), $request->input('price_max')]);
                });
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
                    'price' => $q->orderByRaw('COALESCE(rent_price_per_day, rent_price_per_month, regular_price) ASC'),
                    'date' => $q->orderByDesc('created_at'),
                    default => $q->latest(),
                };
            }, function ($q) {
                $q->latest();
            })
            ->paginate($perPage);

        return response()->json([
            'data' => $cars->items(),
            'current_page' => $cars->currentPage(),
            'last_page' => $cars->lastPage(),
            'per_page' => $cars->perPage(),
            'total' => $cars->total(),
        ]);
    }

    /**
     * Display rent-only car index page (same UI as listing).
     */
    public function auction()
    {
        return view('car.auction');
    }

    /**
     * Filter cars for auction page - shows ONLY cars with active auctions.
     */
    public function filterAuction(Request $request)
    {
        $cars = Car::query()
            // Show ONLY cars that have active auctions
            ->whereHas('auctions', function ($subQuery) {
                $subQuery->where('status', 'active');
            })
            ->with(['auctions' => function ($q) {
                $q->where('status', 'active')->latest();
            }])
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
            ->when($request->input('price_min') && $request->input('price_max'), function ($q) use ($request) {
                // Use auction starting price for filtering
                $q->whereHas('auctions', function ($auctionQuery) use ($request) {
                    $auctionQuery->where('status', 'active')
                        ->whereBetween('starting_price', [$request->input('price_min'), $request->input('price_max')]);
                });
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
                    'price' => $q->orderByRaw('(SELECT starting_price FROM auctions WHERE auctions.car_id = cars.id AND auctions.status = "active" ORDER BY created_at DESC LIMIT 1) ASC'),
                    'date' => $q->orderByDesc('created_at'),
                    default => $q->latest(),
                };
            }, function ($q) {
                // Default sort by latest
                $q->latest();
            })
            ->paginate(15)
            ->withQueryString();

        return response()->json($cars);
    }

    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        // Check if user is trying to register as a bargain
        $bargainId = request()->query('bargain_id');
        $bargain = null;

        if ($bargainId && Auth::check()) {
            // Get the bargain and verify it belongs to the user
            $bargain = Auth::user()->bargains()->find($bargainId);

            // Check if bargain has restrictions
            if ($bargain) {
                // If bargain is blocked, redirect with error
                if ($bargain->registration_status === 'blocked') {
                    return redirect()->back()->with('error', 'Your bargain is currently blocked. You cannot register cars at this time.');
                }

                // If bargain is restricted, check if restriction period is still active
                if ($bargain->registration_status === 'restricted' && $bargain->hasActiveRestriction()) {
                    return redirect()->back()->with('error', 'Your bargain is currently restricted until ' . $bargain->restriction_ends_at->format('M d, Y') . '. You cannot register cars during this period.');
                }
            }
        }

        return view('car.register', compact('bargain'));
    }

    /**
     * @param StoreCarRequest $request
     */
    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();

        try {
            Log::info('Car store method started');
            Log::info('Validated data:', $data);

            // Check if registering as a bargain
            $bargainId = $data['bargain_id'] ?? null;
            $bargain = null;

            if ($bargainId && Auth::check()) {
                // Get the bargain and verify it belongs to the user
                $bargain = Auth::user()->bargains()->find($bargainId);

                // Check if bargain has restrictions
                if ($bargain) {
                    // If bargain is blocked, return error
                    if ($bargain->registration_status === 'blocked') {
                        if ($request->wantsJson()) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Your bargain is currently blocked. You cannot register cars at this time.'
                            ], 403);
                        }
                        return back()->with('error', 'Your bargain is currently blocked. You cannot register cars at this time.');
                    }

                    // If bargain is restricted, check if restriction period is still active
                    if ($bargain->registration_status === 'restricted' && $bargain->hasActiveRestriction()) {
                        $restrictionMessage = 'Your bargain is currently restricted until ' . $bargain->restriction_ends_at->format('M d, Y') . '. You cannot register cars during this period.';
                        if ($request->wantsJson()) {
                            return response()->json([
                                'success' => false,
                                'message' => $restrictionMessage
                            ], 403);
                        }
                        return back()->with('error', $restrictionMessage);
                    }
                }
            }

            // Handle image uploads
            $images = [];
            if ($request->hasFile('images')) {
                /** @var array<int, \Illuminate\Http\UploadedFile> $imageFiles */
                $imageFiles = (array) $request->file('images');
                foreach ($imageFiles as $image) {
                    $images[] = str_replace('public/', '', $image->store('images/car', 'public'));
                }
            }
            Log::info('Processed images:', $images);

            // Handle video uploads
            $videos = [];
            if ($request->hasFile('videos')) {
                /** @var array<int, \Illuminate\Http\UploadedFile> $videoFiles */
                $videoFiles = (array) $request->file('videos');
                foreach ($videoFiles as $video) {
                    $videos[] = str_replace('public/', '', $video->store('videos/car', 'public'));
                }
            }
            Log::info('Processed videos:', $videos);

            $carData = [
                'user_id' => Auth::check() ? Auth::id() : 1, // Use authenticated user or default to 1
                'bargain_id' => $bargainId ?? null, // Set bargain_id if provided
                'title' => $data['title'],
                'year' => $data['year'],
                'make' => $data['make'],
                'VIN_number' => $data['VIN_number'] ?? null,
                'location' => $data['location'] ?? null,
                'model' => $data['model'],
                'car_color' => $data['car_color'],
                'transmission_type' => $data['transmission_type'] ?? null,
                'regular_price' => $data['regular_price'] ?? null,
                'body_type' => $data['body_type'] ?? null,
                'car_condition' => $data['car_condition'] ?? null,
                'car_documents' => $data['car_documents'] ?? null,
                'car_inside_color' => $data['car_inside_color'] ?? null,
                'currency_type' => $data['currency_type'] ?? null,

                'description' => $data['description'] ?? null,
                'is_for_sale' => (bool) ($data['is_for_sale'] ?? false),
                'is_for_rent' => (bool) ($data['is_for_rent'] ?? false),
                'is_promoted' => (bool) ($data['is_promoted'] ?? false),
                'rent_price_per_day' => $data['rent_price_per_day'] ?? null,
                'rent_price_per_month' => $data['rent_price_per_month'] ?? null,
                'request_price_status' => (bool) ($data['request_price_status'] ?? false),
                'request_price' => $data['request_price'] ?? null,
                'images' => $images,
                'videos' => $videos,
            ];

            Log::info('Car data to be created:', $carData);

            $car = Car::create($carData);
            Log::info('Car created successfully with ID: ' . $car->id);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Car created successfully.',
                    'car' => $car
                ]);
            }

            return redirect()->route('car.index')->with('success', 'Car created successfully.');
        } catch (\Throwable $th) {
            Log::error('Error storing car: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while saving the car: ' . $th->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Something went wrong while saving the car: ' . $th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new car.
     */
    public function show($id)
    {
        $car = Car::with('promotions')->findOrFail($id);

        // Increment view count
        $car->increment('views');

        $activePromotion = $car->promotions()
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->latest('ends_at')
            ->first();
        $hasActivePromotion = (bool) $activePromotion;
        $activePromotionEndsAt = $activePromotion?->ends_at; // Carbon|null

        // Get the active auction for this car
        $auction = $car->auctions->first();

        $makes = Car::where('make', $car->make)->limit(10)->get();
        return view('car.show', compact('car', 'makes', 'hasActivePromotion', 'activePromotionEndsAt', 'auction'));
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
        $cars = Car::whereHas('promotions', function ($q) {
            $q->where(function ($q2) {
                $q2->whereNull('ends_at')->orWhere('ends_at', '>', now());
            });
        })->latest()->take(15)->get();
        return response()->json($cars);
    }

    public function togglePromoted($id)
    {
        $car = Car::findOrFail($id);
        $car->is_promoted = ! $car->is_promoted;
        $car->save();
        return response()->json(['status' => 'ok', 'is_promoted' => $car->is_promoted]);
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
