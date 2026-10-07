<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Nieuwe Boeking') }}
            </h2>
        </div>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="mb-4">
            <a href="{{ route('bookings.index') }}" class="text-blue-400 hover:text-blue-300">
                <i class="fas fa-arrow-left mr-1"></i> Terug naar boekingen
            </a>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold text-white mb-6">Nieuwe Boeking Aanmaken</h1>

            @if ($errors->any())
                <div class="bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-6" role="alert">
                    <div class="font-bold">Er zijn fouten opgetreden:</div>
                    <ul class="list-disc pl-5 mt-2">
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

            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6" id="bookingForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Selection -->
                    <div>
                        <label for="customer_id" class="block text-gray-300 mb-2">Klant</label>
                        <select name="customer_id" id="customer_id" required
                                class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecteer een klant</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->person->first_name }} {{ $customer->person->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trip Selection -->
                    <div>
                        <label for="trip_id" class="block text-gray-300 mb-2">Reis</label>
                        <select name="trip_id" id="trip_id" required
                                class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecteer een reis</option>
                            @foreach ($trips as $trip)
                                <option value="{{ $trip->id }}" {{ old('trip_id') == $trip->id ? 'selected' : '' }}>
                                    {{ $trip->flight_number }} - {{ $trip->departure->country }} naar {{ $trip->destination->country }} 
                                    ({{ \Carbon\Carbon::parse($trip->departure_date)->format('d M Y') }} {{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Seat Number -->
                    <div>
                        <label for="seat_number" class="block text-gray-300 mb-2">Stoelnummer</label>
                        <input type="text" name="seat_number" id="seat_number" required value="{{ old('seat_number') }}"
                               class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="bijv. A12">
                    </div>

                    <!-- Purchase Date -->
                    <div>
                        <label for="purchase_date" class="block text-gray-300 mb-2">Aankoopdatum</label>
                        <input type="date" name="purchase_date" id="purchase_date" required value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Purchase Time -->
                    <div>
                        <label for="purchase_time" class="block text-gray-300 mb-2">Aankooptijd</label>
                        <input type="time" name="purchase_time" id="purchase_time" required value="{{ old('purchase_time', now()->format('H:i')) }}"
                               class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Booking Status -->
                    <div>
                        <label for="booking_status" class="block text-gray-300 mb-2">Status</label>
                        <select name="booking_status" id="booking_status" required
                                class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Confirmed" {{ old('booking_status') == 'Confirmed' ? 'selected' : '' }}>Bevestigd</option>
                            <option value="Pending" {{ old('booking_status') == 'Pending' ? 'selected' : '' }}>In afwachting</option>
                            <option value="Cancelled" {{ old('booking_status') == 'Cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-gray-300 mb-2">Prijs (€)</label>
                        <input type="number" name="price" id="price" required value="{{ old('price') }}" step="0.01" min="0"
                               class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0,00">
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-gray-300 mb-2">Aantal</label>
                        <input type="number" name="quantity" id="quantity" required value="{{ old('quantity', 1) }}" min="1"
                               class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Special Requests -->
                <div>
                    <label for="special_requests" class="block text-gray-300 mb-2">Speciale Verzoeken</label>
                    <textarea name="special_requests" id="special_requests" rows="3"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Voeg hier eventuele speciale verzoeken toe...">{{ old('special_requests') }}</textarea>
                </div>

                <!-- Notes -->
                <div>
                    <label for="note" class="block text-gray-300 mb-2">Notities</label>
                    <textarea name="note" id="note" rows="3"
                            class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Voeg hier eventuele notities toe...">{{ old('note') }}</textarea>
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 bg-gray-700 text-blue-600 rounded" 
                            {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 text-gray-300">Actieve boeking</label>
                </div>

                <!-- Developer Connection -->
                <div class="flex items-center">
                    <input type="checkbox" name="dev_connection" id="dev_connection" class="h-5 w-5 bg-gray-700 text-blue-600 rounded" checked>
                    <label for="dev_connection" class="ml-2 text-gray-300 font-semibold">Connectie. Alleen voor developers.</label>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('bookings.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Annuleren
                    </a>
                    <button type="submit" id="submitButton"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Boeking Aanmaken
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            const devConnection = document.getElementById('dev_connection');
            const submitButton = document.getElementById('submitButton');

            form.addEventListener('submit', function(e) {
                if (!devConnection.checked) {
                    e.preventDefault();
                    
                    // Toon direct de foutmelding zonder redirect
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-6';
                    errorDiv.setAttribute('role', 'alert');
                    
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'font-bold';
                    errorMsg.textContent = 'Geen connectie met de server, probeer later opnieuw.';
                    
                    errorDiv.appendChild(errorMsg);
                    
                    // Plaats de foutmelding bovenaan het formulier
                    const heading = document.querySelector('h1.text-2xl');
                    heading.insertAdjacentElement('afterend', errorDiv);
                    
                    // Scroll naar boven om de foutmelding te tonen
                    window.scrollTo(0, 0);
                }
            });
        });
    </script>
</x-app-layout>