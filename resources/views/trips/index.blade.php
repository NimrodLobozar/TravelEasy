<x-html-layout>
    @if ($trips->isNotEmpty())
        @php
            $destinationCountry = $trips->first()->destination_country;
            $imagePath = public_path("img/Countries/{$destinationCountry}");
            $images = file_exists($imagePath)
                ? glob(public_path("img/Countries/{$destinationCountry}/*.{jpg,jpeg,png,gif}"), GLOB_BRACE)
                : [];
            $firstImage = $images ? asset("img/Countries/{$destinationCountry}/" . basename($images[0])) : null;
        @endphp
    @endif

    <div class="min-h-screen py-6  bg-cover bg-center"
        style="background-image: url('{{ $firstImage ?? asset('default-background.jpg') }}'); filter: brightness(1);">
        <div class="container mx-auto text-gray-900">
            @if ($trips->isNotEmpty() && $firstImage)
                <div class="relative p-4 mb-6 bg-white bg-opacity-60 rounded-lg shadow-md">
                    <h1 class="text-4xl font-bold">{{ $destinationCountry }}</h1>
                    <h2 class="text-3xl font-bold">Available Trips</h2>
                </div>
            @endif
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-1/6 h-full bg-gray-100 p-4 fixed left-0 top-0 bottom-0">
                    <h2 class="text-2xl font-bold mb-4">Filter by Date</h2>
                    <form method="GET" action="{{ route('trips.index') }}">
                        <label class="block text-gray-700 font-bold mb-2">Select Dates:</label>
                        <div class="mb-4">
                            @php
                                $uniqueDates = $trips->pluck('departure_date')->unique();
                            @endphp
                            @foreach ($uniqueDates as $date)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="date-{{ $date }}" name="dates[]"
                                        value="{{ $date }}" class="mr-2"
                                        {{ request('dates') && in_array($date, request('dates')) ? 'checked' : '' }}>
                                    <label for="date-{{ $date }}"
                                        class="text-gray-700">{{ $date }}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Filter
                        </button>
                    </form>
                </div>

                <!-- Main Content -->
                <div class="ml-1/4 w-full p-4">
                    @if ($trips->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($trips as $trip)
                                <div
                                    class="flex justify-between items-center block bg-white bg-opacity-80 rounded-lg shadow-md p-6 hover:shadow-xl">
                                    <div>
                                        <p class="text-xl font-bold text-black">{{ $trip->departure_country }} to
                                            {{ $trip->destination_country }}
                                        </p>
                                        <p class="text-gray-600">{{ $trip->flight_number }}</p>
                                        <p class="text-gray-600"><b>Departure: <u>{{ $trip->departure_date }}
                                                    {{ $trip->departure_time }}</u></b></p>
                                        <p class="text-gray-600"><b>Destination: <u>{{ $trip->arrival_date }}
                                                    {{ $trip->arrival_time }}</u></b>
                                        </p>
                                        <p class="text-gray-600"><b>Status:</b> {{ $trip->trip_status }}</p>
                                        <a href="#"
                                            class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-700 text-center">No trips available for the selected dates.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-html-layout>
