<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bargain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'seller_id',
        'seeker_id',
        'details',
        'price',
        'status',
    ];

    /**
     * Get the seller (user) for the bargain.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the seeker (user) for the bargain.
     */
    public function seeker()
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

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