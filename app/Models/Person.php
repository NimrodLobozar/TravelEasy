<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\Contact;
use App\Models\Employee;

class Person extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'passport_details',
        'note',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function contacts()
    {
        return $this->hasOne(Contact::class);
    }
}
