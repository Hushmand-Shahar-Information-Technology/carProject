<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bargain extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'profile_image',
        'website',
        'email',
        'registration_number',
        'phone',
        'whatsapp',
        'address',
        'edit_frequent',
        'status',
        'contract_start_date',
        'contract_end_date',
        'registration_status',
        'restriction_count',
        'status_reason',
        'status_updated_at',
        'restriction_starts_at',
        'restriction_ends_at',
        'restriction_duration_days',
    ];

    protected $dates = ['contract_start_date', 'contract_end_date', 'status_updated_at', 'restriction_starts_at', 'restriction_ends_at'];

    protected $casts = [
        'contract_start_date' => 'date:Y-m-d',
        'contract_end_date' => 'date:Y-m-d',
        'status_updated_at' => 'datetime',
        'restriction_starts_at' => 'datetime',
        'restriction_ends_at' => 'datetime',
        'restriction_count' => 'integer',
        'restriction_duration_days' => 'integer',
    ];

    public function promotions()
    {
        return $this->morphMany(\App\Models\Promotion::class, 'promotable');
    }

    /**
     * Check if user is currently under active restriction
     */
    public function hasActiveRestriction()
    {
        return $this->registration_status === 'restricted' && 
               $this->restriction_ends_at && 
               $this->restriction_ends_at->isFuture();
    }

    /**
     * Check if restriction has expired
     */
    public function isRestrictionExpired()
    {
        return $this->restriction_ends_at && 
               $this->restriction_ends_at->isPast();
    }

    /**
     * Get remaining restriction time in human readable format
     */
    public function getRestrictionTimeRemaining()
    {
        if (!$this->restriction_ends_at || $this->restriction_ends_at->isPast()) {
            return null;
        }
        
        return $this->restriction_ends_at->diffForHumans();
    }

    /**
     * Check if user can promote (not restricted or blocked)
     */
    public function canPromote()
    {
        // Cannot promote if blocked
        if ($this->registration_status === 'blocked') {
            return false;
        }
        
        // Cannot promote if actively restricted
        if ($this->hasActiveRestriction()) {
            return false;
        }
        
        return true;
    }
}