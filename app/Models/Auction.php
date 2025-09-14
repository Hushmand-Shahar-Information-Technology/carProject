<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'car_id',
        'starting_price',
        'auction_type',
        'duration_days',
        'end_at',
        'status',
        'message',
    ];

    protected $casts = [
        'end_at' => 'datetime',
        'starting_price' => 'decimal:2',
    ];


    // Optional helper to check if auction is active
    public function isActive()
    {
        return $this->status === 'active' && (is_null($this->end_at) || $this->end_at->isFuture());
    }

    // Relationship: Auction belongs to a Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
