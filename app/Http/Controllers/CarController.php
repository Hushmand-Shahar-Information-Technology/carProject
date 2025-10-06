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
            ->when($request->query('Body', []), function ($q, $bodies) {
                $q->whereIn('body_type', $bodies);
            })
            ->when($request->query('Color', []), function ($q, $colors) {
                $q->whereIn('car_color', $colors);
            })
            ->when($request->query('Transmission', []), function ($q, $transmissions) {
                $q->whereIn('transmission_type', $transmissions);
            })
            ->when($request->query('Condition', []), function ($q, $conditions) {
                $q->whereIn('car_condition', $conditions);
            })
            ->when($request->input('sort'), function ($q, $sort) {
                switch ($sort) {
                    case 'year_asc':
                        $q->orderBy('year', 'asc');
                        break;
                    case 'year_desc':
                        $q->orderBy('year', 'desc');
                        break;
                    case 'price_asc':
                        $q->orderBy('regular_price', 'asc');
                        break;
                    case 'price_desc':
                        $q->orderBy('regular_price', 'desc');
                        break;
                    case 'created_at_desc':
                        $q->orderBy('created_at', 'desc');
                        break;
                    case 'created_at_asc':
                        $q->orderBy('created_at', 'asc');
                        break;
                }
            })
            ->paginate(15)
            ->withQueryString();

        return response()->json($cars);
    }
    /**
     * Display the rent car index.
     */
    public function rentIndex()
    {
        return view('car.rent-listing');
    }
    public function filterRent(Request $request)
    {
        $cars = Car::query()
            ->with('bargain')
            ->where('is_for_rent', 1)
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
                $q->whereBetween('rent_price_per_day', [$request->input('price_min'), $request->input('price_max')])
                    ->orWhereBetween('rent_price_per_month', [$request->input('price_min'), $request->input('price_max')]);
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
            ->when($request->query('Body', []), function ($q, $bodies) {
                $q->whereIn('body_type', $bodies);
            })
            ->when($request->query('Color', []), function ($q, $colors) {
                $q->whereIn('car_color', $colors);
            })
            ->when($request->query('Transmission', []), function ($q, $transmissions) {
                $q->whereIn('transmission_type', $transmissions);
            })
            ->when($request->query('Condition', []), function ($q, $conditions) {
                $q->whereIn('car_condition', $conditions);
            })
            ->when($request->input('sort'), function ($q, $sort) {
                switch ($sort) {
                    case 'year_asc':
                        $q->orderBy('year', 'asc');
                        break;
                    case 'year_desc':
                        $q->orderBy('year', 'desc');
                        break;
                    case 'price_asc':
                        $q->orderBy('rent_price_per_day', 'asc')->orderBy('rent_price_per_month', 'asc');
                        break;
                    case 'price_desc':
                        $q->orderBy('rent_price_per_day', 'desc')->orderBy('rent_price_per_month', 'desc');
                        break;
                    case 'created_at_desc':
                        $q->orderBy('created_at', 'desc');
                        break;
                    case 'created_at_asc':
                        $q->orderBy('created_at', 'asc');
                        break;
                }
            })
            ->paginate(15)
            ->withQueryString();

        return response()->json($cars);
    }

    public function auction()
    {
        return view('car.auction');
    }

    public function filterAuction(Request $request)
    {
        $cars = Car::query()
            ->with(['bargain', 'auctions' => function ($query) {
                $query->where('status', 'active')->latest();
            }])
            // Show ONLY cars that have active auctions
            ->whereHas('auctions', function ($subQuery) {
                $subQuery->where('status', 'active');
            })
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
                // For auctions, we might want to filter by starting bid or current bid
                // This would depend on your auction implementation
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
            ->when($request->query('Body', []), function ($q, $bodies) {
                $q->whereIn('body_type', $bodies);
            })
            ->when($request->query('Color', []), function ($q, $colors) {
                $q->whereIn('car_color', $colors);
            })
            ->when($request->query('Transmission', []), function ($q, $transmissions) {
                $q->whereIn('transmission_type', $transmissions);
            })
            ->when($request->query('Condition', []), function ($q, $conditions) {
                $q->whereIn('car_condition', $conditions);
            })
            ->when($request->input('sort'), function ($q, $sort) {
                switch ($sort) {
                    case 'year_asc':
                        $q->orderBy('year', 'asc');
                        break;
                    case 'year_desc':
                        $q->orderBy('year', 'desc');
                        break;
                    case 'price_asc':
                        // For auctions, this might be starting bid or current bid
                        $q->orderBy('regular_price', 'asc');
                        break;
                    case 'price_desc':
                        // For auctions, this might be starting bid or current bid
                        $q->orderBy('regular_price', 'desc');
                        break;
                    case 'created_at_desc':
                        $q->orderBy('created_at', 'desc');
                        break;
                    case 'created_at_asc':
                        $q->orderBy('created_at', 'asc');
                        break;
                }
            })
            ->paginate(15)
            ->withQueryString();

        return response()->json($cars);
    }

    /**
     * Show the form for creating a new car.
     */
    public function create(Request $request)
    {
        // Check if user is trying to register as a bargain
        $bargainId = $request->query('bargain_id');
        $bargain = null;

        if ($bargainId && Auth::check()) {
            // Get the bargain and verify it belongs to the user
            $bargain = Auth::user()->bargains()->find($bargainId);

            // Prevent bargains from registering other bargains
            if ($bargain) {
                // Check if this is a bargain trying to register as another bargain
                if ($request->has('bargain_registration')) {
                    return redirect()->back()->with('error', 'Bargains cannot register other bargains.');
                }
            }

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

        // Check if user is currently in bargain mode (trying to register a new bargain)
        if (session('profile_mode') === 'bargain' && session('active_bargain_id')) {
            // Get the active bargain
            $activeBargain = Auth::user()->bargains()->find(session('active_bargain_id'));

            // If user is in bargain mode, redirect them to profile with SweetAlert message
            if ($activeBargain) {
                return redirect()->route('user.profile', ['bargain_id' => $activeBargain->id])
                    ->with('error', 'You are currently in bargain mode. To register a new bargain, please switch to user profile mode first.');
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


            // Handle image uploads
            $images = [];
            if (request()->hasFile('images')) {
                $imageFiles = request()->file('images');
                if (is_array($imageFiles)) {
                    foreach ($imageFiles as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            $images[] = str_replace('public/', '', $image->store('images/car', 'public'));
                        }
                    }
                }
            }
            Log::info('Processed images:', $images);

            // Handle video uploads
            $videos = [];
            if (request()->hasFile('videos')) {
                $videoFiles = request()->file('videos');
                if (is_array($videoFiles)) {
                    foreach ($videoFiles as $video) {
                        if ($video instanceof \Illuminate\Http\UploadedFile) {
                            $videos[] = str_replace('public/', '', $video->store('videos/car', 'public'));
                        }
                    }
                }
            }
            Log::info('Processed videos:', $videos);

            $carData = [
                'user_id' => Auth::check() ? Auth::id() : 1, // Use authenticated user or default to 1
                'title' => $data['title'],
                'year' => $data['year'],
                'make' => $data['make'],
                'VIN_number' => $data['VIN_number'] ?? null,
                'location' => $data['location'] ?? null,
                'model' => $data['model'],
                'car_color' => $data['car_color'],
                'transmission_type' => in_array($data['transmission_type'] ?? null, ['manual', 'automatic']) ? $data['transmission_type'] : null,
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

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Car created successfully.',
                    'car' => $car
                ]);
            }

            // Redirect back to the correct profile page
            $bargainId = $data['bargain_id'] ?? session('active_bargain_id') ?? null;
            if ($bargainId) {
                // Store the bargain mode in session to persist after redirect
                session(['profile_mode' => 'bargain', 'active_bargain_id' => $bargainId]);
                return redirect()->route('user.profile', ['bargain_id' => $bargainId])->with('success', 'Car created successfully.');
            } else {
                // Store the user mode in session
                session(['profile_mode' => 'user']);
                return redirect()->route('user.profile')->with('success', 'Car created successfully.');
            }
        } catch (\Throwable $th) {
            Log::error('Error storing car: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while saving the car: ' . $th->getMessage()
                ], 500);
            }

            // Redirect back to the correct profile page even on error
            $bargainId = $data['bargain_id'] ?? session('active_bargain_id') ?? null;
            if ($bargainId) {
                return redirect()->route('user.profile', ['bargain_id' => $bargainId])->withInput()->withErrors(['error' => 'Something went wrong while saving the car: ' . $th->getMessage()]);
            } else {
                return redirect()->route('user.profile')->withInput()->withErrors(['error' => 'Something went wrong while saving the car: ' . $th->getMessage()]);
            }
        }
    }

    /**
     * Show the form for creating a new car.
     */
    public function show($id)
    {
        $car = Car::with(['promotions', 'user', 'auctions', 'offers'])->findOrFail($id);

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
        $auction = $car->auctions()
            ->where('status', 'active')
            ->latest()
            ->first();

        $makes = Car::where('make', $car->make)->limit(10)->get();
        return view('car.show', compact('car', 'makes', 'hasActivePromotion', 'activePromotionEndsAt', 'auction'));
    }

    /**
     * Get offers for a specific car (AJAX endpoint)
     */
    public function getOffers($id)
    {
        $car = Car::with('offers')->findOrFail($id);

        // Ensure only the car owner can access offers
        if (!Auth::check() || $car->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Format offers for JSON response
        $formattedOffers = $car->offers->map(function ($offer) {
            return [
                'id' => $offer->id,
                'name' => $offer->name,
                'phone' => $offer->phone,
                'email' => $offer->email,
                'price' => $offer->price,
                'remark' => $offer->remark,
                'created_at' => $offer->created_at->toIso8601String(),
                'formatted_date' => $offer->created_at->format('M d, Y'),
                'formatted_time' => $offer->created_at->format('g:i A')
            ];
        });

        return response()->json([
            'offers' => $formattedOffers->sortByDesc('created_at')->values(),
            'count' => $car->offers->count(),
            'stats' => [
                'highest' => $car->offers->max('price'),
                'average' => $car->offers->avg('price'),
                'asking' => $car->regular_price
            ]
        ]);
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

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        // Check if user is authorized to delete this car
        $this->authorize('delete', $car);

        try {
            // Delete associated images from storage
            if (!empty($car->images) && is_array($car->images)) {
                foreach ($car->images as $imagePath) {
                    // Remove 'storage/' prefix if it exists
                    $cleanPath = str_replace('storage/', '', $imagePath);
                    $fullPath = storage_path('app/public/' . $cleanPath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            // Delete associated videos from storage
            if (!empty($car->videos) && is_array($car->videos)) {
                foreach ($car->videos as $videoPath) {
                    // Remove 'storage/' prefix if it exists
                    $cleanPath = str_replace('storage/', '', $videoPath);
                    $fullPath = storage_path('app/public/' . $cleanPath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            $car->delete();

            // For AJAX requests or API calls, always return JSON
            if (request()->wantsJson() || request()->isXmlHttpRequest() || request()->method() === 'DELETE') {
                return response()->json([
                    'success' => true,
                    'message' => 'Car deleted successfully.'
                ]);
            }

            return redirect()->route('user.profile')->with('success', 'Car deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Error deleting car: ' . $th->getMessage());

            // For AJAX requests or API calls, always return JSON
            if (request()->wantsJson() || request()->isXmlHttpRequest() || request()->method() === 'DELETE') {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the car: ' . $th->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors(['error' => 'Something went wrong while deleting the car: ' . $th->getMessage()]);
        }
    }
}
