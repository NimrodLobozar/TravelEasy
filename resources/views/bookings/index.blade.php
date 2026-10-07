<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Boekingen') }}
            </h2>
            <label class="flex items-center">
                <span class="mr-2 text-gray-200">Toon Data</span>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="dataToggle"
                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                        checked />
                    <label for="dataToggle"
                        class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </label>
        </div>
    </x-slot>

    <div id="dataContainer" class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-900 border-t-4 border-green-600 rounded-b px-4 py-3 text-green-200" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('connection_error'))
            <div class="bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-4" role="alert">
                <div class="font-bold">{{ session('connection_error') }}</div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-white">Boekingen</h1>
            <a href="{{ route('bookings.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nieuwe Boeking</a>
        </div>

        <!-- Search Form -->
        <div class="mb-6 bg-gray-800 p-4 rounded-lg">
            <form action="{{ route('bookings.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="departure_date" class="block text-gray-300 mb-2">Vertrekdatum</label>
                    <input type="date" name="departure_date" id="departure_date" 
                           value="{{ request('departure_date') }}"
                           class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="departure_time" class="block text-gray-300 mb-2">Vertrektijd</label>
                    <input type="time" name="departure_time" id="departure_time" 
                           value="{{ request('departure_time') }}"
                           class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="destination" class="block text-gray-300 mb-2">Bestemming</label>
                    <input type="text" name="destination" id="destination" 
                           value="{{ request('destination') }}"
                           class="w-full bg-gray-700 text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Zoek bestemming...">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Zoeken
                    </button>
                    @if(request('departure_date') || request('departure_time') || request('destination'))
                        <a href="{{ route('bookings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Wissen
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Developer Connection Toggle (Hidden) -->
        <div class="mb-4">
            <div class="flex items-center">
                <input type="checkbox" id="dev_connection" class="h-5 w-5 bg-gray-700 text-blue-600 rounded" checked>
                <label for="dev_connection" class="ml-2 text-gray-300 font-semibold">Connectie. Alleen voor developers.</label>
            </div>
        </div>

        @if($bookings->isEmpty())
            <div class="bg-yellow-900 border-t-4 border-yellow-600 rounded-b px-4 py-3 text-yellow-200 mb-4">
                Kan geen boekingen vinden.
            </div>
        @else
            <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="py-2 px-4 text-left text-gray-200">Klant</th>
                        <th class="py-2 px-4 text-left text-gray-200">Vluchtnummer</th>
                        <th class="py-2 px-4 text-left text-gray-200">Vertrek</th>
                        <th class="py-2 px-4 text-left text-gray-200">Bestemming</th>
                        <th class="py-2 px-4 text-left text-gray-200">Vertrektijd</th>
                        <th class="py-2 px-4 text-left text-gray-200">Stoelnummer</th>
                        <th class="py-2 px-4 text-left text-gray-200">Status</th>
                        <th class="py-2 px-4 text-left text-gray-200">Prijs</th>
                        <th class="py-2 px-4 text-left text-gray-200">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t border-gray-700 hover:bg-gray-700">
                            <td class="py-2 px-4 text-gray-300">{{ $booking->customer->person->first_name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 text-gray-300">{{ $booking->trip->flight_number ?? 'N/A' }}</td>
                            <td class="py-2 px-4 text-gray-300">{{ $booking->trip->departure->country ?? 'N/A' }}</td>
                            <td class="py-2 px-4 text-gray-300">{{ $booking->trip->destination->country ?? 'N/A' }}</td>
                            <td class="py-2 px-4 text-gray-300">
                                {{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('d M Y') }}
                                {{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('H:i') }}
                            </td>
                            <td class="py-2 px-4 text-gray-300">{{ $booking->seat_number }}</td>
                            <td class="py-2 px-4 text-gray-300">{{ $booking->booking_status }}</td>
                            <td class="py-2 px-4 text-gray-300">€{{ number_format($booking->price, 2, ',', '.') }}</td>
                            <td class="py-2 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bekijken</a>
                                    <a href="{{ route('bookings.edit', $booking->id) }}"
                                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Bewerken</a>
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                                        class="delete-form" data-id="{{ $booking->id }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-button"
                                            data-id="{{ $booking->id }}">Verwijderen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-4 text-gray-300">
            {{ $bookings->links() }}
        </div>
    </div>

    <div id="errorContainer" class="container mx-auto mt-8 hidden ml-64">
        <p class="text-red-500">Geen boekingen gevonden.</p>
    </div>
</x-app-layout>

<script>
    document.getElementById('dataToggle').addEventListener('change', function() {
        const dataContainer = document.getElementById('dataContainer');
        const errorContainer = document.getElementById('errorContainer');
        if (this.checked) {
            dataContainer.classList.remove('hidden');
            errorContainer.classList.add('hidden');
        } else {
            dataContainer.classList.add('hidden');
            errorContainer.classList.remove('hidden');
        }
    });

    // Handle delete buttons with connection check
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        const devConnection = document.getElementById('dev_connection');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // First confirm the delete action
                if (!confirm('Weet je zeker dat je deze boeking wilt verwijderen?')) {
                    e.preventDefault();
                    return;
                }
                
                // Then check for developer connection
                if (!devConnection.checked) {
                    e.preventDefault();
                    
                    // Create error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-4';
                    errorDiv.setAttribute('role', 'alert');
                    
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'font-bold';
                    errorMsg.textContent = 'Kan boeking niet verwijderen. probeer het later opnieuw.';
                    
                    errorDiv.appendChild(errorMsg);
                    
                    // Remove any existing error messages
                    const existingErrors = document.querySelectorAll('[role="alert"]');
                    existingErrors.forEach(el => {
                        if (el.textContent.includes('Kan boeking niet verwijderen')) {
                            el.remove();
                        }
                    });
                    
                    // Add error message to the top of the data container
                    const dataContainer = document.getElementById('dataContainer');
                    const searchForm = document.querySelector('.mb-6.bg-gray-800');
                    dataContainer.insertBefore(errorDiv, searchForm);
                    
                    // Scroll to top to show the error
                    window.scrollTo(0, 0);
                }
            });
        });
    });
</script>

<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #68D391;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #68D391;
    }
</style>