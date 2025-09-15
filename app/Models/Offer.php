<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
   protected $fillable = [
    'name', 'phone', 'email', 'price', 'car_id', 'remark',
];


    public function car(){
        return $this -> belongsTo(Car::class);
    }
}