<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Bargain;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        return view('promotions.index');
    }

    public function list(Request $request)
    {
        $type = $request->query('type', 'car');
        if ($type === 'bargain') {
            $promoted = Promotion::with('promotable')
                ->where('promotable_type', Bargain::class)
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
                })
                ->latest()->get();
        } else {
            $promoted = Promotion::with('promotable')
                ->where('promotable_type', Car::class)
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
                })
                ->latest()->get();
        }

        return response()->json($promoted);
    }

    public function promote(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:car,bargain',
            'id' => 'required|integer',
            'days' => 'required|integer|min:1|max:365',
        ]);
        $endsAt = now()->addDays($data['days']);

        $model = $data['type'] === 'car' ? Car::class : Bargain::class;
        /** @var \Illuminate\Database\Eloquent\Model $record */
        $record = $model::findOrFail($data['id']);

        $record->promotions()->create([
            'starts_at' => now(),
            'ends_at' => $endsAt,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['status' => 'ok', 'ends_at' => $endsAt->toDateTimeString()]);
    }

    public function unpromote(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:car,bargain',
            'id' => 'required|integer',
        ]);
        $model = $data['type'] === 'car' ? Car::class : Bargain::class;
        /** @var \Illuminate\Database\Eloquent\Model $record */
        $record = $model::findOrFail($data['id']);
        $record->promotions()->where(function ($q) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })
            ->delete();
        return response()->json(['status' => 'ok']);
    }
}
