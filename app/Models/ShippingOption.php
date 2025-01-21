<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingOption extends Model
{
    protected $casts = [
        'id' => 'string',
    ];
}
