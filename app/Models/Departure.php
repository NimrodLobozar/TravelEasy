<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'airport',
        'departure_date', // Added field
        'departure_time', // Added field
        'arrival_date',   // Added field
        'arrival_time',   // Added field
        'is_active',
        'note',
    ];
}
