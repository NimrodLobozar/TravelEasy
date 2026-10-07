<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'trip.departure', 'trip.destination']);

        // Search by departure date
        if ($request->filled('departure_date')) {
            $query->whereHas('trip', function ($q) use ($request) {
                $q->whereDate('departure_date', $request->departure_date);
            });
        }

        // Search by departure time
        if ($request->filled('departure_time')) {
            $query->whereHas('trip', function ($q) use ($request) {
                $q->where('departure_time', 'LIKE', $request->departure_time . '%');
            });
        }

        // Search by destination
        if ($request->filled('destination')) {
            $query->whereHas('trip.destination', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->destination . '%');
            });
        }

        $bookings = $query->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        $customers = Customer::with('person')->get();
        $trips = Trip::with(['departure', 'destination'])->get();

        // Check if there's a connection error message in the session
        return view('bookings.create', compact('customers', 'trips'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        // Check developer connection
        if (!$request->has('dev_connection')) {
            return redirect()->route('bookings.create')
                ->with('connection_error', 'Kan boeking niet opslaan. probeer het later opnieuw.');
        }

        // Transform the checkbox value
        $input = $request->all();
        $input['is_active'] = $request->has('is_active') ? true : false;

        $validator = Validator::make($input, [
            'customer_id' => 'required|exists:customers,id',
            'trip_id' => 'required|exists:trips,id',
            'seat_number' => 'required|string',
            'purchase_date' => 'required|date',
            'purchase_time' => 'required',
            'booking_status' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'is_active' => 'boolean',
            'note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $booking = Booking::create($input);

        return redirect()->route('bookings.index')
            ->with('success', 'Boeking succesvol aangemaakt');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['customer.person', 'trip.departure', 'trip.destination']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        $customers = Customer::with('person')->get();
        $trips = Trip::with(['departure', 'destination'])->get();

        return view('bookings.edit', compact('booking', 'customers', 'trips'));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        // Check developer connection
        if (!$request->has('dev_connection')) {
            return redirect()->route('bookings.edit', $booking->id)
                ->with('connection_error', 'Kan boeking niet bijwerken. probeer het later opnieuw.');
        }

        // Transform the checkbox value
        $input = $request->all();
        $input['is_active'] = $request->has('is_active') ? true : false;

        $validator = Validator::make($input, [
            'customer_id' => 'exists:customers,id',
            'trip_id' => 'exists:trips,id',
            'seat_number' => 'string',
            'purchase_date' => 'date',
            'purchase_time' => 'date_format:H:i:s',
            'booking_status' => 'string',
            'price' => 'numeric|min:0',
            'quantity' => 'integer|min:1',
            'special_requests' => 'nullable|string',
            'is_active' => 'boolean',
            'note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $booking->update($input);

        return redirect()->route('bookings.index')
            ->with('success', 'Boeking succesvol bijgewerkt');
    }

    /**
     * Remove the specified booking.
     */
    /**
     * Remove the specified booking.
     */
    public function destroy(Request $request, Booking $booking)
    {
        // Check developer connection
        if (!$request->has('dev_connection')) {
            return redirect()->route('bookings.index')
                ->with('connection_error', 'Kan boeking niet verwijderen. probeer het later opnieuw.');
        }

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Boeking succesvol verwijderd');
    }

    public function getBookingStats()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Maandelijkse statistieken
        $monthlyStats = collect(range(1, $currentMonth))->mapWithKeys(function ($month) use ($currentYear) {
            $count = Booking::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->count();
            return [$month => $count];
        })->toArray();

        // Maandelijkse omzet
        $monthlyRevenue = collect(range(1, $currentMonth))->mapWithKeys(function ($month) use ($currentYear) {
            $revenue = Booking::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum(\DB::raw('price * quantity'));
            return [$month => $revenue ?? 0];
        })->toArray();

        // Kwartaal statistieken
        $quarterlyStats = Booking::selectRaw('QUARTER(created_at) as quarter, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('quarter')
            ->orderBy('quarter')
            ->get()
            ->pluck('count', 'quarter')
            ->toArray();

        // Top 5 bestemmingen
        $topDestinations = Booking::select('trips.destination_id')
            ->join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->join('destinations', 'trips.destination_id', '=', 'destinations.id')
            ->selectRaw('destinations.country, destinations.airport, COUNT(*) as booking_count')
            ->groupBy('trips.destination_id', 'destinations.country', 'destinations.airport')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get();

        return [
            'monthly' => $monthlyStats,
            'quarterly' => $quarterlyStats,
            'monthlyRevenue' => $monthlyRevenue,
            'topDestinations' => $topDestinations
        ];
    }
}
