<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bargain extends Model
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
    ];

    protected $dates = ['contract_start_date', 'contract_end_date'];

    protected $casts = [
        'contract_start_date' => 'date:Y-m-d',
        'contract_end_date' => 'date:Y-m-d',
    ];
}
