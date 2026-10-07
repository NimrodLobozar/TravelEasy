<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Boeking Bewerken') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-gray-800 rounded-lg shadow-sm p-6">
            @if ($errors->any())
                <div class="bg-red-900 border-l-4 border-red-600 p-4 mb-4">
                    <ul class="text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('connection_error'))
                <div class="bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-6" role="alert">
                    <div class="font-bold">{{ session('connection_error') }}</div>
                </div>
            @endif

            <form action="{{ route('bookings.update', $booking->id) }}" method="POST" id="bookingForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Selection -->
                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Klant</label>
                        <select name="customer_id"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $booking->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->person->first_name }} {{ $customer->person->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trip Selection -->
                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Vlucht</label>
                        <select name="trip_id"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                            @foreach ($trips as $trip)
                                <option value="{{ $trip->id }}"
                                    {{ $booking->trip_id == $trip->id ? 'selected' : '' }}>
                                    {{ $trip->flight_number }} - {{ $trip->departure->country }} naar
                                    {{ $trip->destination->country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Booking Details -->
                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Stoelnummer</label>
                        <input type="text" name="seat_number"
                            value="{{ old('seat_number', $booking->seat_number) }}"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Status</label>
                        <select name="booking_status"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                            <option value="bevestigd" {{ $booking->booking_status == 'bevestigd' ? 'selected' : '' }}>
                                Bevestigd
                            </option>
                            <option value="geannuleerd"
                                {{ $booking->booking_status == 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            <option value="in behandeling"
                                {{ $booking->booking_status == 'in behandeling' ? 'selected' : '' }}>In behandeling
                            </option>
                        </select>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Aankoopdatum</label>
                        <input type="date" name="purchase_date"
                            value="{{ old('purchase_date', \Carbon\Carbon::parse($booking->purchase_date)->format('Y-m-d')) }}"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Aankooptijd</label>
                        <input type="time" name="purchase_time"
                            value="{{ old('purchase_time', \Carbon\Carbon::parse($booking->purchase_time)->format('H:i:s')) }}"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500" step="1">
                    </div>


                    <!-- Pricing -->
                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Prijs per stuk</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $booking->price) }}"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Aantal</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $booking->quantity) }}"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500">
                    </div>

                    <!-- Additional Fields -->
                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Speciale verzoeken</label>
                        <textarea name="special_requests" class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500"
                            rows="3">{{ old('special_requests', $booking->special_requests) }}</textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-gray-300 mb-2">Notities</label>
                        <textarea name="note" class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:ring-blue-500" rows="3">{{ old('note', $booking->note) }}</textarea>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="is_active" id="is_active"
                            class="rounded bg-gray-700 border-gray-600" {{ $booking->is_active ? 'checked' : '' }}>
                        <label for="is_active" class="text-gray-300">Actieve boeking</label>
                    </div>

                    <!-- Developer Connection -->
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="dev_connection" id="dev_connection"
                            class="h-5 w-5 bg-gray-700 text-blue-600 rounded" checked>
                        <label for="dev_connection" class="text-gray-300 font-semibold">Connectie. Alleen voor developers.</label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('bookings.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Annuleren
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            const devConnection = document.getElementById('dev_connection');

            form.addEventListener('submit', function(e) {
                if (!devConnection.checked) {
                    e.preventDefault();
                    
                    // Toon direct de foutmelding zonder redirect
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-6';
                    errorDiv.setAttribute('role', 'alert');
                    
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'font-bold';
                    errorMsg.textContent = 'Kan boeking niet bijwerken. probeer het later opnieuw.';
                    
                    errorDiv.appendChild(errorMsg);
                    
                    // Verwijder bestaande foutmeldingen indien aanwezig
                    const existingErrors = document.querySelectorAll('[role="alert"]');
                    existingErrors.forEach(el => el.remove());
                    
                    // Plaats de foutmelding bovenaan het formulier
                    form.insertBefore(errorDiv, form.firstChild);
                    
                    // Scroll naar boven om de foutmelding te tonen
                    window.scrollTo(0, 0);
                }
            });
        });
    </script>
</x-app-layout>