<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartureController extends Controller
{

    public function index()
    {
        // $departures = DB::table('departures')->get() ?? [];
        // $destinations = DB::table('destinations')->get() ?? [];
        $departures = DB::select('CALL spGetTripDetails()') ?? [];
        $destinations = DB::select('CALL spGetTripDetails()') ?? [];

        return view('departure.index', compact('departures', 'destinations'));
    }

    public function getDepartures()
    {
        return DB::table('departures')->get();
    }

    public function getDestinations()
    {
        return DB::table('destinations')->get();
    }
}
