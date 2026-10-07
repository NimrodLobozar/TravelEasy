<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{

    use HasFactory;

    protected $fillable = [
        'trip_id',
        'offer_code',
        'discount_percentage',
        'valid_from',
        'valid_until',
        'is_active',
        'note',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());
    }
    public function scopeExpired($query)
    {
        return $query->where('is_active', true)
            ->where('valid_until', '<', now());
    }
    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '>', now());
    }
    public function scopePast($query)
    {
        return $query->where('is_active', false)
            ->where('valid_until', '<', now());
    }
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());
    }
    public function scopeInvalid($query)
    {
        return $query->where('is_active', false)
            ->orWhere(function ($q) {
                $q->where('valid_from', '>', now())
                    ->orWhere('valid_until', '<', now());
            });
    }
    public function scopeActiveAndValid($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());
    }
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}
