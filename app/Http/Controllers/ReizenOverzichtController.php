<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReizenOverzicht;
use Illuminate\Support\Facades\DB;

class ReizenOverzichtController extends Controller
{
    public function index()
    {
        $reizen = ReizenOverzicht::with(['departure', 'destination'])->get(); // Haal gerelateerde gegevens op
        return view('reisoverzicht.index', compact('reizen'));
    }

    public function show($id)
    {
        $reis = ReizenOverzicht::findOrFail($id);
        return view('reisoverzicht.show', compact('reis'));
    }
    public function create()
    {
        $employees = \App\Models\Employee::with('person')->where('is_active', true)->get();
        return view('reisoverzicht.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'departure_country' => 'required|string|max:255',
            'departure_airport' => 'required|string|max:255',
            'arrival_country' => 'required|string|max:255',
            'arrival_airport' => 'required|string|max:255',
            'flight_number' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|date_format:H:i',
            'trip_status' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'note' => 'nullable|string',
        ]);
    
        // Call the stored procedure
        DB::statement('CALL spCreateReis(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('employee_id'),
            $request->input('departure_country'),
            $request->input('departure_airport'),
            $request->input('arrival_country'),
            $request->input('arrival_airport'),
            $request->input('flight_number'),
            $request->input('departure_date'),
            $request->input('departure_time'),
            $request->input('arrival_date'),
            $request->input('arrival_time'),
            $request->input('trip_status'),
            $request->input('is_active'),
            $request->input('note'),
        ]);
    
        return redirect()->route('reisoverzicht.index')->with('success', 'Reis succesvol aangemaakt.');
    }

    public function edit($id)
    {
        $reis = ReizenOverzicht::findOrFail($id);
        return view('reisoverzicht.edit', compact('reis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'departure_country' => 'required|string|max:255',
            'departure_airport' => 'required|string|max:255',
            'arrival_country' => 'required|string|max:255',
            'arrival_airport' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required|date_format:H:i',
            'note' => 'nullable|string',
        ]);

        $reis = ReizenOverzicht::with(['departure', 'destination'])->findOrFail($id);

        // Call the stored procedure
        DB::statement('CALL spEditReis(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $reis->departure_id,
            $request->input('departure_country'),
            $request->input('departure_airport'),
            $request->input('arrival_country'),
            $request->input('arrival_airport'),
            $reis->id,
            $request->input('departure_date'),
            $request->input('departure_time'),
            $request->input('arrival_date'),
            $request->input('arrival_time'),
        ]);

        // Update the note field in the trips table
        $reis->update([
            'note' => $request->input('note'),
        ]);

        return redirect()->route('reisoverzicht.index')->with('success', 'Reis succesvol bijgewerkt.');
    }

    public function destroy($id)
    {
        $reis = ReizenOverzicht::findOrFail($id);
        $reis->delete();

        return redirect()->route('reisoverzicht.index')->with('success', 'Reis succesvol verwijderd.');
    }
}