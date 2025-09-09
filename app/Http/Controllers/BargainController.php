<?php

namespace App\Http\Controllers;

use App\Models\Bargain;
use App\services\BargainService;
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

        // Order by newest first (descending)
        $bargains->orderBy('created_at', 'desc');

        $data = $bargains->get()->map(function ($b, $index) {
            return [
                'id' => $b->id,
                'count' => $index + 1,
                'tenant_name' => '<a href="' . route('bargains.show', $b->id) . '" style="cursor:pointer; text-decoration: none; color:black;">' . $b->name . '</a>',
                'tenant_father_name' => $b->username,
                'contract_company_name' => $b->website ?? '-',
                'contract_purpose' => $b->status,
                'contract_location' => $b->address ?? '-',
                'contract_from_date' => $b->contract_start_date?->format('Y-m-d') ?? '-',
                'contract_to_date' => $b->contract_end_date?->format('Y-m-d') ?? '-',
                'written_contract_number' => $b->registration_number,
                'registration_status' => $b->registration_status ?? 'pending',
                'restriction_count' => $b->restriction_count ?? 0,
                'can_manage_status' => auth()->check() && $this->canManageStatus(),
                'showUrl' => route('bargains.show', $b->id),
                'editUrl' => route('bargains.edit', $b->id),
                'deleteUrl' => route('bargains.destroy', $b->id),
                'toggleUrl' => route('bargains.toggle-status', $b->id),
                'statusUrl' => route('bargains.update-status', $b->id),
                'warningUrl' => route('bargains.send-warning', $b->id),
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
        $activePromotionEndsAt = $activePromotion?->ends_at; // Carbon|null
        return view('bargains.show', compact('bargain', 'hasActivePromotion', 'activePromotionEndsAt'));
    }

    /**
     * Update bargain registration status
     */
    public function updateStatus(Request $request, $id)
    {
        // Temporarily disabled for testing - enable auth check in production
        // if (!auth()->check() || !$this->canManageStatus()) {
        //     abort(403, 'Unauthorized to manage bargain status');
        // }
        
        $bargain = Bargain::findOrFail($id);
        $oldStatus = $bargain->registration_status;
        
        // Handle reset restrictions action
        if ($request->has('reset_restrictions') && $request->reset_restrictions) {
            $bargain->restriction_count = 0;
            $bargain->restriction_starts_at = null;
            $bargain->restriction_ends_at = null;
            $bargain->restriction_duration_days = null;
            $bargain->status_reason = null;
            $bargain->status_updated_at = now();
            $bargain->save();
            
            return response()->json(['message' => 'All restrictions cleared successfully!']);
        }
        
        $request->validate([
            'status' => 'required|in:pending,approved,blocked,restricted',
            'description' => 'nullable|string|max:500',
            'restriction_days' => 'nullable|integer|min:1|max:365'
        ]);

        $newStatus = $request->status;
        $description = $request->description;
        $restrictionDays = $request->restriction_days ?? 7; // Default 7 days

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

        return response()->json(['message' => $message]);
    }

    /**
     * Send warning to bargain user
     */
    public function sendWarning(Request $request, $id)
    {
        // Temporarily disabled for testing - enable auth check in production
        // if (!auth()->check() || !$this->canManageStatus()) {
        //     abort(403, 'Unauthorized to send warnings');
        // }
        
        $request->validate([
            'warning_message' => 'nullable|string|max:500'
        ]);
        
        $bargain = Bargain::findOrFail($id);
        $warningMessage = $request->warning_message;
        
        // Here you could implement actual warning notification logic
        // For now, we'll store it in the status_reason field with a timestamp
        
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
            'message' => $responseMessage
        ]);
    }

    /**
     * Check if current user can manage bargain status
     */
    private function canManageStatus(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        
        // First check if user has admin email (fallback for systems without roles)
        if (in_array($user->email, ['admin@example.com', 'admin@admin.com', 'dev@dev.com'])) {
            return true;
        }
        
        // Check if the system has roles/permissions and user has admin role
        try {
            if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                return true;
            }
            
            if (method_exists($user, 'can') && $user->can('manage_bargain_status')) {
                return true;
            }
        } catch (\Exception $e) {
            // If roles/permissions are not set up, default to false
            return false;
        }
        
        return false;
    }
}
