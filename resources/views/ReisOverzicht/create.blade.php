<x-app-layout>
    <div class="min-h-screen p-6 flex items-center justify-center dark:bg-gray-900 dark:text-white">
        <div class="container max-w-screen-lg mx-auto">

            @if ($errors->any())
                <div class="bg-red-100 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-700" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div>
                <h2 class="font-semibold text-xl text-gray-600 dark:text-gray-300">Reis formulier</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Vul het formulier in om een nieuwe reis toe te voegen.</p>

                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-800">
                    <form action="{{ route('reisoverzicht.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600 dark:text-gray-300">
                                <p class="font-medium text-lg">Reis Gegevens</p>
                                <p>Vul alle velden in.</p>
                            </div>

                            <div class="md:col-span-5">
                                <label for="employee_id">Employee</label>
                                <select name="employee_id" id="employee_id"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="">Selecteer een medewerker</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->person->first_name }} {{ $employee->person->last_name }} ({{ $employee->number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-5">
                                <label for="departure_country">Departure Country</label>
                                <input type="text" id="departure_country" name="departure_country"
                                    value="{{ old('departure_country') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. Nederland, Duitsland, China, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="departure_airport">Departure Airport</label>
                                <input type="text" id="departure_airport" name="departure_airport"
                                    value="{{ old('departure_airport') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. Schiphol, Frankfurt Airport, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="arrival_country">Arrival Country</label>
                                <input type="text" id="arrival_country" name="arrival_country"
                                    value="{{ old('arrival_country') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. Verenigde Staten, Frankrijk, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="arrival_airport">Arrival Airport</label>
                                <input type="text" id="arrival_airport" name="arrival_airport"
                                    value="{{ old('arrival_airport') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. JFK, Charles de Gaulle, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="flight_number">Flight Number</label>
                                <input type="text" id="flight_number" name="flight_number"
                                    value="{{ old('flight_number') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. KL1234, LH5678, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="departure_date">Departure Date</label>
                                <input type="date" id="departure_date" name="departure_date"
                                    value="{{ old('departure_date') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="departure_time">Departure Time</label>
                                <input type="time" id="departure_time" name="departure_time"
                                    value="{{ old('departure_time') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="arrival_date">Arrival Date</label>
                                <input type="date" id="arrival_date" name="arrival_date"
                                    value="{{ old('arrival_date') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="arrival_time">Arrival Time</label>
                                <input type="time" id="arrival_time" name="arrival_time"
                                    value="{{ old('arrival_time') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full" />
                            </div>

                            <div class="md:col-span-5">
                                <label for="trip_status">Trip Status</label>
                                <input type="text" id="trip_status" name="trip_status"
                                    value="{{ old('trip_status', 'Scheduled') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. Scheduled, In Progress, Completed, enz." />
                            </div>

                            <div class="md:col-span-5">
                                <label for="status">Status</label>
                                <select name="is_active" id="status"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Actief</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactief</option>
                                </select>
                            </div>

                            <div class="md:col-span-5">
                                <label for="note">Note (optioneel)</label>
                                <input type="text" id="note" name="note"
                                    value="{{ old('note') }}"
                                    class="mt-1 px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 rounded w-full"
                                    placeholder="Bijv. Opmerkingen over de reis." />
                            </div>

                            <div class="md:col-span-5 text-right">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Verstuur</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>