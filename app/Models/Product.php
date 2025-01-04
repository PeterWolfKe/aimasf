<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'size',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
