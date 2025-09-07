<?php

namespace App\Models;

use App\Models\BaseModel;

class Offer extends BaseModel
{
   protected $fillable = [
    'name', 'phone', 'email', 'price', 'car_id', 'remark',
];


    public function car(){
        return $this -> belongsTo(Car::class);
    }
}