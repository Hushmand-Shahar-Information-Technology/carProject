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
        $typeRaw = $request->query('type', 'car');
        $type = in_array($typeRaw, ['bargain', 'bargains'], true) ? 'bargain' : 'car';
        $q = trim((string) $request->query('q', ''));
        $promoted = Promotion::with('promotable')
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->when($type === 'bargain', function ($q) {
                $q->where(function ($qq) {
                    $qq->whereHasMorph('promotable', [Bargain::class])
                       ->orWhereIn('promotable_type', [
                           'bargain', Bargain::class, 'App\\Bargain', 'App\\Models\\Bargain'
                       ]);
                });
            }, function ($q) {
                $q->where(function ($qq) {
                    $qq->whereHasMorph('promotable', [Car::class])
                       ->orWhereIn('promotable_type', [
                           'car', Car::class, 'App\\Car', 'App\\Models\\Car'
                       ]);
                });
            })
            ->latest()
            ->get()
            ->filter(function ($promo) {
                return !is_null($promo->promotable);
            })
            ->values();
        if ($q !== '') {
            $needle = mb_strtolower($q);
            $promoted = $promoted->filter(function ($promo) use ($type, $needle) {
                if (! $promo->promotable) return false;
                if ($type === 'bargain') {
                    $name = mb_strtolower(($promo->promotable->name ?? '') . ' ' . ($promo->promotable->username ?? ''));
                    return str_contains($name, $needle);
                }
                $title = mb_strtolower(($promo->promotable->title ?? '') . ' ' . ($promo->promotable->model ?? ''));
                return str_contains($title, $needle);
            })->values();
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
        
        $model = $data['type'] === 'car' ? Car::class : Bargain::class;
        /** @var \Illuminate\Database\Eloquent\Model $record */
        $record = $model::findOrFail($data['id']);
        
        // Check if bargain user can promote (not restricted or blocked)
        if ($data['type'] === 'bargain' && !$record->canPromote()) {
            $reason = $record->registration_status === 'blocked' 
                ? 'User is blocked and cannot promote their bargain'
                : ($record->hasActiveRestriction() 
                    ? 'User is under restriction until ' . $record->restriction_ends_at->format('M d, Y') . ' and cannot promote'
                    : 'User cannot promote at this time');
                    
            return response()->json([
                'status' => 'error',
                'message' => $reason
            ], 403);
        }
        
        $endsAt = now()->addDays($data['days']);

        $record->promotions()->create([
            'starts_at' => now(),
            'ends_at' => $endsAt,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'ok',
            'ends_at' => $endsAt->toDateTimeString(),
            'ends_at_iso' => $endsAt->toIso8601String(),
        ]);
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
