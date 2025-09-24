<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bargain;
use App\services\BargainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BargainController extends Controller
{
    protected $service;

    public function __construct(BargainService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bargain::query();

        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%")
                    ->orWhere('website', 'like', "%$search%")
                    ->orWhere('registration_number', 'like', "%$search%");
            });
        }

        // Apply status filter if provided
        if ($request->has('status') && $request->status) {
            $query->where('registration_status', $request->status);
        }

        // Order by newest first
        $query->orderBy('created_at', 'desc');

        $bargains = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $bargains
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'registration_number' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'nullable|string|max:50',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after:contract_start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $bargain = $this->service->save($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bargain created successfully',
            'data' => $bargain
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bargain = Bargain::with(['promotions', 'cars.auctions'])->findOrFail($id);

        // Check if restriction has expired and auto-remove it
        if ($bargain->isRestrictionExpired() && $bargain->registration_status === 'restricted') {
            $bargain->registration_status = 'approved';
            $bargain->restriction_starts_at = null;
            $bargain->restriction_ends_at = null;
            $bargain->restriction_duration_days = null;
            $bargain->status_reason = 'Restriction period expired - automatically approved';
            $bargain->status_updated_at = now();
            $bargain->save();
        }

        $activePromotion = $bargain->promotions()
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->latest('ends_at')
            ->first();

        $hasActivePromotion = (bool) $activePromotion;
        $activePromotionEndsAt = $activePromotion?->ends_at;

        return response()->json([
            'success' => true,
            'data' => [
                'bargain' => $bargain,
                'has_active_promotion' => $hasActivePromotion,
                'active_promotion_ends_at' => $activePromotionEndsAt
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bargain = Bargain::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255',
            'website' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'registration_number' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'nullable|string|max:50',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date|after:contract_start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updatedBargain = $this->service->save($request->all(), $bargain);
            
            return response()->json([
                'success' => true,
                'message' => 'Bargain updated successfully',
                'data' => $updatedBargain
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bargain = Bargain::findOrFail($id);
        $bargain->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bargain deleted successfully'
        ]);
    }

    /**
     * Toggle bargain status
     */
    public function toggleStatus($id)
    {
        $bargain = Bargain::findOrFail($id);
        $this->service->toggleStatus($bargain);

        return response()->json([
            'success' => true,
            'message' => 'Status toggled successfully',
            'data' => $bargain->fresh()
        ]);
    }

    /**
     * Update bargain registration status
     */
    public function updateStatus(Request $request, $id)
    {
        $bargain = Bargain::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,blocked,restricted',
            'description' => 'nullable|string|max:500',
            'restriction_days' => 'nullable|integer|min:1|max:365',
            'reset_restrictions' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $oldStatus = $bargain->registration_status;
        $newStatus = $request->status;
        $description = $request->description;
        $restrictionDays = $request->restriction_days ?? 7;
        $resetRestrictions = $request->reset_restrictions ?? false;

        // Handle reset restrictions action
        if ($resetRestrictions) {
            $bargain->restriction_count = 0;
            $bargain->restriction_starts_at = null;
            $bargain->restriction_ends_at = null;
            $bargain->restriction_duration_days = null;
            $bargain->status_reason = null;
            $bargain->status_updated_at = now();
            $bargain->save();

            return response()->json([
                'success' => true,
                'message' => 'All restrictions cleared successfully!',
                'data' => $bargain->fresh()
            ]);
        }

        // Handle restriction count logic
        if ($newStatus === 'restricted') {
            $bargain->restriction_count = ($bargain->restriction_count ?? 0) + 1;

            // Set restriction duration
            $bargain->restriction_starts_at = now()->startOfDay();
            $bargain->restriction_ends_at = now()->addDays($restrictionDays)->endOfDay();
            $bargain->restriction_duration_days = $restrictionDays;

            // Ensure restriction count doesn't exceed 3
            if ($bargain->restriction_count > 3) {
                $bargain->restriction_count = 3;
            }

            // Auto-block after 3 restrictions
            if ($bargain->restriction_count >= 3) {
                $newStatus = 'blocked';
                $bargain->restriction_starts_at = null;
                $bargain->restriction_ends_at = null;
                $bargain->restriction_duration_days = null;
                $bargain->status_reason = $description ?
                    "Automatically blocked after 3 restrictions. Admin note: {$description}" :
                    'Automatically blocked after 3 restrictions';
            } else {
                $bargain->status_reason = $description ?
                    "Restriction #{$bargain->restriction_count}/3 for {$restrictionDays} days. Admin note: {$description}" :
                    "Restriction #{$bargain->restriction_count}/3 for {$restrictionDays} days - ends on {$bargain->restriction_ends_at->format('M d, Y')}";
            }
        } elseif ($newStatus === 'approved' || $newStatus === 'pending') {
            // Reset restriction count and clear restriction timers when status goes back to approved or pending
            $bargain->restriction_count = 0;
            $bargain->restriction_starts_at = null;
            $bargain->restriction_ends_at = null;
            $bargain->restriction_duration_days = null;
            if ($newStatus === 'approved') {
                $bargain->status_reason = $description ? "Approved. Admin note: {$description}" : null;
            } else {
                $bargain->status_reason = $description ? "Set to pending. Admin note: {$description}" : 'Status reset to pending by administrator';
            }
        } elseif ($newStatus === 'blocked') {
            // Clear restriction timers when blocking
            $bargain->restriction_starts_at = null;
            $bargain->restriction_ends_at = null;
            $bargain->restriction_duration_days = null;
            $bargain->status_reason = $description ?
                "Account blocked by administrator. Reason: {$description}" :
                'Account blocked by administrator';
        }

        $bargain->registration_status = $newStatus;
        $bargain->status_updated_at = now();
        $bargain->save();

        $statusText = ucfirst($newStatus);
        $message = "User status updated to {$statusText} successfully!";

        if ($newStatus === 'blocked' && $bargain->restriction_count >= 3) {
            $message = "User has been automatically blocked after 3 restrictions!";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $bargain->fresh()
        ]);
    }

    /**
     * Send warning to bargain user
     */
    public function sendWarning(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'warning_message' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $bargain = Bargain::findOrFail($id);
        $warningMessage = $request->warning_message;

        // Here you could implement actual warning notification logic
        $timestamp = now()->format('M d, Y');
        $warningText = $warningMessage ?
            "Warning sent on {$timestamp}: {$warningMessage}" :
            "Warning sent on {$timestamp}: General account activity warning";

        // If there's already a status reason, append the warning
        if ($bargain->status_reason) {
            $bargain->status_reason .= "\n" . $warningText;
        } else {
            $bargain->status_reason = $warningText;
        }

        $bargain->status_updated_at = now();
        $bargain->save();

        $responseMessage = $warningMessage ?
            "Warning sent to {$bargain->name} with custom message." :
            "General warning sent to {$bargain->name}.";

        return response()->json([
            'success' => true,
            'message' => $responseMessage,
            'data' => $bargain->fresh()
        ]);
    }
}