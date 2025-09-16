<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\OfferSubmitted;

class Offer extends Model
{
   protected $fillable = [
    'name', 'phone', 'email', 'price', 'car_id', 'remark',
];


    public function car(){
        return $this -> belongsTo(Car::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($offer) {
            // Send notification to the car owner
            $car = $offer->car;
            if ($car && $car->user) {
                $car->user->notify(new OfferSubmitted($offer));
            }
        });
    }
}