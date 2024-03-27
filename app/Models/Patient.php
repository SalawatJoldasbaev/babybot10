<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'telegram_id',
        'is_verified',
        'polyclinic_phone',
        'polyclinic_address',
    ];
}
