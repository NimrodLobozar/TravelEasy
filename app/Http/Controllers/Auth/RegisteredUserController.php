<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contact;
use App\Models\Person;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Faker\Factory as Faker;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:contacts,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $person = Person::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
        ]);

        $user = User::create([
            'name' => $request->username,
            'password' => Hash::make($request->password),
            'person_id' => $person->id,
        ]);

        $faker = Faker::create();

        $customer = Customer::create([
            'person_id' => $person->id,
            'relation_number' => $faker->unique()->numberBetween(100000, 999999),
        ]);

        Contact::create([
            'customer_id' => $customer->id,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'is_active' => true,
            // ...other required fields for Contact model...
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
