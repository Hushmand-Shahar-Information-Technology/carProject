<?php

namespace App\Http\Controllers;

use App\Models\Bargain;
use App\Services\BargainService;
use App\Http\Requests\BargainRequest;
use Illuminate\Http\Request;

class BargainController extends Controller
{
    protected $service;

    public function __construct(BargainService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('bargains.index');
    }

    public function getData(Request $request)
    {
        $bargains = Bargain::query();

        if ($request->search) {
            $search = $request->search;
            $bargains->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%")
                    ->orWhere('website', 'like', "%$search%")
                    ->orWhere('registration_number', 'like', "%$search%");
            });
        }

        $data = $bargains->get()->map(function ($b, $index) {
            return [
                'count' => $index + 1,
                'tenant_name' => '<a href="' . route('bargains.show', $b->id) . '" style="cursor:pointer; text-decoration: none; color:black;">' . $b->name . '</a>',
                'tenant_father_name' => $b->username,
                'contract_company_name' => $b->website ?? '-',
                'contract_purpose' => $b->status,
                'contract_location' => $b->address ?? '-',
                'contract_from_date' => $b->contract_start_date?->format('Y-m-d') ?? '-',
                'contract_to_date' => $b->contract_end_date?->format('Y-m-d') ?? '-',
                'written_contract_number' => $b->registration_number,
                'editUrl' => route('bargains.edit', $b->id),
                'deleteUrl' => route('bargains.destroy', $b->id),
                'toggleUrl' => route('bargains.toggle-status', $b->id),
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function create()
    {
        return view('bargains.create', ['bargain' => new Bargain()]);
    }

    public function store(BargainRequest $request)
    {
        $this->service->save($request->validated());
        return redirect()->route('bargains.index')->with('success', 'Bargain created successfully!');
    }

    public function edit($id)
    {
        $bargain = Bargain::findOrFail($id);
        return view('bargains.create', compact('bargain'));
    }

    public function update(BargainRequest $request, $id)
    {
        $bargain = Bargain::findOrFail($id);

        try {
            $this->service->save($request->validated(), $bargain);
            return redirect()->route('bargains.index')->with('success', 'Bargain updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $bargain = Bargain::findOrFail($id);
        $bargain->delete();
        return response()->json(['message' => 'Bargain deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $bargain = Bargain::findOrFail($id);
        $this->service->toggleStatus($bargain);
        return response()->json(['message' => 'Status toggled successfully']);
    }
    public function show($id)
    {
        $bargain = Bargain::with('promotions')->findOrFail($id);
        $activePromotion = $bargain->promotions()
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->latest('ends_at')
            ->first();
        $hasActivePromotion = (bool) $activePromotion;
        $activePromotionEndsAt = $activePromotion?->ends_at; // Carbon|null
        return view('bargains.show', compact('bargain', 'hasActivePromotion', 'activePromotionEndsAt'));
    }
}
