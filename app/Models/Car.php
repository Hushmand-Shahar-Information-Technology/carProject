<?php

namespace App\Models;

use App\Enums\TransmissionType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CarColor;


class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;


    protected $guarded = [];

     protected $fillable = [
        'title',
        'year',
        'user_id',
        'make',
        'body_type',
        'car_condition',
        'car_color',
        'car_documents',
        'car_inside_color',
        'VIN_number',
        'location',
        'model',
        'transmission_type',
        'currency_type',
        'regular_price',
        'sale_price',
        'request_price_status',
        'request_price',
        'images',
        'videos',
    ];

    protected $casts = [
        'location' => 'array',
        'images' => 'array',
        'videos' => 'array',
        'request_price_status' => 'boolean',
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'request_price' => 'decimal:2',
        // Remove enum casts:
        // 'transmission_type' => TransmissionType::class,
        // 'car_color' => CarColor::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
