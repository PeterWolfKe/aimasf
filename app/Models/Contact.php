<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'address',
        'apartment_suite',
        'postal_code',
        'city',
        'phone',
        'delivery_method',
        'verified',
    ];
}
