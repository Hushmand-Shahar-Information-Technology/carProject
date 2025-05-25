<?php

namespace App\Models;

use App\enum\TransmissionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;


    protected $guarded = [];
    protected $casts = [
        'location' => 'array',
        'image' => 'array', 
        'transmission_type'=>TransmissionType::class,
    ];

}
