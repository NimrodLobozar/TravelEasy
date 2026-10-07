<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $departureCountry = $request->query('from');
        $destinationCountry = $request->query('to');

        $query = DB::table('trips')
            ->join('departures', 'trips.departure_id', '=', 'departures.id')
            ->join('destinations', 'trips.destination_id', '=', 'destinations.id')
            ->where('departures.country', $departureCountry)
            ->where('destinations.country', $destinationCountry);

        $trips = $query->select('trips.*', 'departures.country as departure_country', 'destinations.country as destination_country')->get();

        return view('trips.index', compact('trips'));
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
