<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinationController extends Controller
{
    public function getDestinationsByDeparture(Request $request)
    {
        $departureCountry = $request->query('departure');
        $destinations = DB::table('trips')
            ->join('destinations', 'trips.destination_id', '=', 'destinations.id')
            ->join('departures', 'trips.departure_id', '=', 'departures.id')
            ->where('departures.country', $departureCountry)
            ->select('destinations.country')
            ->distinct()
            ->get();

        return response()->json($destinations);
    }

    public function getAvailableDates(Request $request)
    {
        $departureCountry = $request->query('from');
        $destinationCountry = $request->query('to');
        $dates = DB::table('trips')
            ->join('departures', 'trips.departure_id', '=', 'departures.id')
            ->join('destinations', 'trips.destination_id', '=', 'destinations.id')
            ->where('departures.country', $departureCountry)
            ->where('destinations.country', $destinationCountry)
            ->where('trips.is_active', true)
            ->pluck('trips.departure_date');

        return response()->json($dates);
    }
}
