<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id', 
        'number', 
        'employee_type', 
        'is_active', 
        'note'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
 
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getFullNameAttribute()
    {
        return $this->person->first_name . ' ' . $this->person->last_name;
    }
}