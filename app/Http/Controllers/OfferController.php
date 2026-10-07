<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index()
    {
        // Replace $arg1 and $arg2 with appropriate values or null if no filtering is needed
        $offers = DB::table('offers')
            ->join('trips', 'offers.trip_id', '=', 'trips.id')
            ->join('departures', 'trips.departure_id', '=', 'departures.id')
            ->join('destinations', 'trips.destination_id', '=', 'destinations.id')
            ->join('bookings', 'bookings.trip_id', '=', 'trips.id')
            ->select('offers.*', 'trips.*', 'departures.*', 'destinations.*', 'bookings.*')
            ->get();
        return view('offers.index', ['offers' => $offers]);
    }
}
