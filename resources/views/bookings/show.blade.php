<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Boeking Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">
                <!-- Customer Section -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold border-b border-gray-700 pb-2">Klant Informatie</h3>
                    @if ($booking->customer && $booking->customer->person)
                        <p><span class="font-semibold">Naam:</span>
                            {{ $booking->customer->person->first_name }}
                            {{ $booking->customer->person->last_name }}
                        </p>
                        <p><span class="font-semibold">Email:</span> {{ $booking->customer->contacts->email ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Telefoon:</span> {{ $booking->customer->contacts->mobile ?? 'N/A' }}
                        </p>
                    @else
                        <p class="text-yellow-500">Klant informatie niet beschikbaar</p>
                    @endif
                </div>

                <!-- Trip Section -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold border-b border-gray-700 pb-2">Vlucht Details</h3>
                    <p><span class="font-semibold">Vluchtnummer:</span> {{ $booking->trip->flight_number ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Vertrek:</span> {{ $booking->trip->departure->country ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Bestemming:</span>
                        {{ $booking->trip->destination->country ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Vertrektijd:</span>
                        {{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('d-m-Y') }}
                        {{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('H:i') }}
                    </p>
                </div>

                <!-- Booking Details -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold border-b border-gray-700 pb-2">Boeking Gegevens</h3>
                    <p><span class="font-semibold">Stoelnummer:</span> {{ $booking->seat_number }}</p>
                    <p><span class="font-semibold">Status:</span> <span
                            class="uppercase">{{ $booking->booking_status }}</span></p>
                    <p><span class="font-semibold">Aantal:</span> {{ $booking->quantity }}</p>
                    <p><span class="font-semibold">Totaal Prijs:</span>
                        €{{ number_format($booking->price * $booking->quantity, 2, ',', '.') }}</p>
                </div>

                <!-- Additional Info -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold border-b border-gray-700 pb-2">Overige Informatie</h3>
                    <p><span class="font-semibold">Aankoopdatum:</span>
                        {{ \Carbon\Carbon::parse($booking->purchase_date)->format('d-m-Y') }}
                        {{ $booking->purchase_time }}
                    </p>
                    <p><span class="font-semibold">Speciale Verzoeken:</span>
                        {{ $booking->special_requests ?? 'Geen' }}</p>
                    <p><span class="font-semibold">Notities:</span> {{ $booking->note ?? 'Geen' }}</p>
                    <p><span class="font-semibold">Status:</span> {{ $booking->is_active ? 'Actief' : 'Inactief' }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('bookings.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Terug
                </a>
                <a href="{{ route('bookings.edit', $booking->id) }}"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Bewerken
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
