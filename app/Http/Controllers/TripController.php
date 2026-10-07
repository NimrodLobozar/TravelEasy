<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function index()
    {
        $trips = DB::select('CALL GetTripDetails()') ?? [];
        $departures = DB::select('CALL GetTripDetails()') ?? [];
        $destinations = DB::select('CALL GetTripDetails()') ?? [];

        return view('trips.index');
    }

    public function create()
    {
        return view('trips.create');
    }

    public function show($trip)
    {
        return view('trips.show', compact('trip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departure_id' => ['required', 'exists:departures,id'],
            'destination_id' => ['required', 'exists:destinations,id'],
            'departure_date' => ['required', 'date'],
            'arrival_date' => ['required', 'date'],
            'price' => ['required', 'numeric'],
            'is_active' => ['required', 'boolean'],
        ]);

        $trip = Trip::create($request->all());

        return redirect()->route('trips.show', $trip);
    }
}
