<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCounter extends Model
{
    protected $fillable = ['year', 'counter'];
}
