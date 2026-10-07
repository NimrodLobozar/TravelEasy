<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReizenOverzicht extends Model
{
    protected $table = 'trips'; // Correct table name

    protected $fillable = [
        'employee_id',
        'departure_id',
        'destination_id',
        'flight_number',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'trip_status',
        'is_active',
        'note',
        'departure_country', // Remove if not in trips table
        'arrival_country'    // Remove if not in trips table
    ];

    protected $casts = [
        'departure_date' => 'date', // Ensure this is cast as 'date'
        'departure_time' => 'string', // Handle as plain string
        'arrival_date' => 'date',   // Ensure this is cast as 'date'
        'arrival_time' => 'string',  // Handle as plain string
        'is_active' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function departure()
    {
        return $this->belongsTo(Departure::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scope for active trips
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper method to check if trip is active
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Helper method to get formatted departure datetime
    public function getDepartureDateTimeAttribute(): string
    {
        return $this->departure_date->format('Y-m-d') . ' ' . substr($this->departure_time, 0, 5); // hh:mm
    }

    // Helper method to get formatted arrival datetime
    public function getArrivalDateTimeAttribute(): string
    {
        return $this->arrival_date->format('Y-m-d') . ' ' . substr($this->arrival_time, 0, 5); // hh:mm
    }
}