<?php

namespace App\Models;

use App\Enums\TransmissionType;
use App\Models\BaseModel;
use App\Enums\CarColor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends BaseModel
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'year',
        'user_id',
        'bargain_id',
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

        'description',
        'request_price_status',
        'request_price',
        'images',
        'videos',
        'is_for_sale',
        'is_for_rent',
        'is_promoted',
        'rent_price_per_day',
        'rent_price_per_month',
        'views',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'request_price_status' => 'boolean',
        'is_for_sale' => 'boolean',
        'is_for_rent' => 'boolean',
        'is_promoted' => 'boolean',
        'regular_price' => 'decimal:2',

        'request_price' => 'decimal:2',
        'rent_price_per_day' => 'decimal:2',
        'rent_price_per_month' => 'decimal:2',
        // Remove enum casts:
        // 'transmission_type' => TransmissionType::class,
        // 'car_color' => CarColor::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bargain()
    {
        return $this->belongsTo(Bargain::class);
    }

    public function promotions()
    {
        return $this->morphMany(\App\Models\Promotion::class, 'promotable');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
