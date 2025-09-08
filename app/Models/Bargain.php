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
    ];

    protected $dates = ['contract_start_date', 'contract_end_date'];

    protected $casts = [
        'contract_start_date' => 'date:Y-m-d',
        'contract_end_date' => 'date:Y-m-d',
    ];

    public function promotions()
    {
        return $this->morphMany(\App\Models\Promotion::class, 'promotable');
    }
}