<x-html-layout>
    <x-banner-layout />
    <div class="mr-64 ml-64 mt-16 h-64 top-full transform -translate-y-1/2 custom-shadow rounded-b-3xl">
        <div class="flex justify-around p-6">
            <div class="w-full">
                <ul class="flex justify-center mb-4">
                    <li class="mr-6">
                        <a id="flights-tab" class="tab-label text-white hover:text-gray-300 cursor-pointer"
                            onclick="showTab('flights')">Flights</a>
                    </li>
                    <li class="mr-6">
                        <a id="vacations-tab" class="tab-label text-white hover:text-gray-300 cursor-pointer"
                            onclick="showTab('vacations')">Vacations</a>
                    </li>
                    <li class="mr-6">
                        <a id="cruises-tab" class="tab-label text-white hover:text-gray-300 cursor-pointer"
                            onclick="showTab('cruises')">Cruises</a>
                    </li>
                </ul>
                <div id="flights" class="tab-content">
                    <div class="flex justify-around p-4">
                        <div class="w-64 mb-6">
                            <x-input-label for="from" :value="__('Van')" />
                            <select id="from" class="block w-full bg-gray-100 rounded py-2 px-1" name="from"
                                required oninput="updateDestinations()">
                                @foreach ($departures as $departure)
                                    <option value="{{ $departure->country }}">{{ $departure->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="to" :value="__('Naar')" />
                            <select id="to" class="block mt-1 w-full bg-gray-100 rounded py-2 px-1"
                                name="to" required>
                                <option value="">Select a destination</option>
                            </select>
                        </div>

                        {{-- <div class="w-64 mb-6">
                            <x-input-label for="date" :value="__('Wanneer?')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                onfocus="showDatePicker()" />
                        </div> --}}
                        {{-- <form action="{{ route('trips.index') }}" method="GET" class="flex space-x-4">
                            <!-- Dropdown voor startdatum & einddatum -->
                            <div class="flex items-center space-x-4 bg-white p-4 rounded-lg shadow-md">
                                <input type="text" name="start_date"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                                    placeholder="Kies startdatum" value="{{ request('start_date') }}" id="start_date">

                                <span class="text-gray-500 font-medium">tot</span>

                                <input type="text" name="end_date"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                                    placeholder="Kies einddatum" value="{{ request('end_date') }}" id="end_date">
                            </div>

                            <!-- Maak Selectie Knop -->
                            <button type="submit"
                                class="bg-blue-300 text-white px-4 py-2 rounded-lg shadow hover:bg-green-300">
                                Maak selectie
                            </button>
                        </form> --}}

                        {{-- <div class="w-64 mb-6">
                            <x-input-label for="date" :value="__('Waneer')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                onfocus="showDatePicker()" />
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="return_date" :value="__('Terug')" />
                            <x-text-input id="return_date" class="block mt-1 w-full" type="date" name="return_date"
                                oninput="validateFields('flights')" />
                        </div> --}}
                    </div>
                    <div class="text-center">
                        <button id="flights-book-button"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition duration-300"
                            disabled onclick="book('flights')">
                            Boeken
                        </button>
                    </div>
                </div>
                <div id="vacations" class="tab-content hidden">
                    <div class="flex justify-around p-6">
                        <div class="w-64 mb-6">
                            <x-input-label for="vacation_type" :value="__('Vakantietype')" />
                            <x-text-input id="vacation_type" class="block mt-1 w-full" type="text"
                                name="vacation_type" oninput="validateFields('vacations')" />
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="destination" :value="__('Bestemming')" />
                            <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination"
                                oninput="validateFields('vacations')" />
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="vacation_date" :value="__('Wanneer?')" />
                            <x-text-input id="vacation_date" class="block mt-1 w-full" type="date"
                                name="vacation_date" oninput="validateFields('vacations')" />
                        </div>
                        <div class="w-64 mb-6 relative">
                            <x-input-label for="vacation_people" :value="__('Wie?')" />
                            <button id="vacation_people"
                                class="block mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 text-left cursor-pointer"
                                onclick="toggleDropdown('peopleDropdown')">
                                2 volwassenen
                            </button>
                            <div id="peopleDropdown"
                                class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg p-4 hidden">
                                <p class="font-semibold">Jouw reisgezelschap</p>
                                <p class="text-sm text-gray-500">Het reisgezelschap mag uit max. 8 personen
                                    bestaan.</p>
                                <p class="text-sm text-gray-500">Wil je een baby (t/m 1 jaar) meenemen, neem dan
                                    contact op met ons TUI Customer Services Center</p>
                                <div class="mt-4">
                                    <label class="block font-semibold">Volwassenen (18+ jaar)</label>
                                    <div class="flex items-center mt-1">
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="decrement('adults')">-</button>
                                        <input id="adults" type="text" value="2"
                                            class="w-12 text-center mx-2 border border-gray-300 rounded-md" readonly>
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="increment('adults')">+</button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block font-semibold">Kinderen (2-17 jaar)</label>
                                    <div class="flex items-center mt-1">
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="decrement('children')">-</button>
                                        <input id="children" type="text" value="0"
                                            class="w-12 text-center mx-2 border border-gray-300 rounded-md" readonly>
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="increment('children')">+</button>
                                    </div>
                                    <div id="children-ages" class="mt-2"></div>
                                    <p class="text-sm text-gray-500">Het is de leeftijd op dag van vertrek.</p>
                                </div>
                                <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md"
                                    onclick="savePeople()">Opslaan</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="vacations-book-button"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition duration-300"
                            disabled onclick="book('vacations')">
                            Boeken
                        </button>
                    </div>
                </div>
                <div id="cruises" class="tab-content hidden">
                    <div class="flex justify-around p-6">
                        <div class="w-64 mb-6">
                            <x-input-label for="cruise_type" :value="__('Soort cruise')" />
                            <x-text-input id="cruise_type" class="block mt-1 w-full" type="text"
                                name="cruise_type" oninput="validateFields('cruises')" />
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="cruise_area" :value="__('Vaargebied')" />
                            <x-text-input id="cruise_area" class="block mt-1 w-full" type="text"
                                name="cruise_area" oninput="validateFields('cruises')" />
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="cruise_date" :value="__('Wanneer?')" />
                            <x-text-input id="cruise_date" class="block mt-1 w-full" type="date"
                                name="cruise_date" oninput="validateFields('cruises')" />
                        </div>
                        <div class="w-64 mb-6 relative">
                            <x-input-label for="cruise_people" :value="__('Wie?')" />
                            <button id="cruise_people"
                                class="block mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 text-left cursor-pointer"
                                onclick="toggleDropdown('cruisePeopleDropdown')">
                                2 volwassenen
                            </button>
                            <div id="cruisePeopleDropdown"
                                class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-lg p-4 hidden">
                                <p class="font-semibold">Jouw reisgezelschap</p>
                                <p class="text-sm text-gray-500">Het reisgezelschap mag uit max. 8 personen
                                    bestaan.</p>
                                <p class="text-sm text-gray-500">Wil je een baby (t/m 1 jaar) meenemen, neem dan
                                    contact op met ons TUI Customer Services Center</p>
                                <div class="mt-4">
                                    <label class="block font-semibold">Volwassenen (18+ jaar)</label>
                                    <div class="flex items-center mt-1">
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="decrement('cruiseAdults')">-</button>
                                        <input id="cruiseAdults" type="text" value="2"
                                            class="w-12 text-center mx-2 border border-gray-300 rounded-md" readonly>
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="increment('cruiseAdults')">+</button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block font-semibold">Kinderen (2-17 jaar)</label>
                                    <div class="flex items-center mt-1">
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="decrement('cruiseChildren')">-</button>
                                        <input id="cruiseChildren" type="text" value="0"
                                            class="w-12 text-center mx-2 border border-gray-300 rounded-md" readonly>
                                        <button class="bg-gray-200 px-2 py-1 rounded-md"
                                            onclick="increment('cruiseChildren')">+</button>
                                    </div>
                                    <div id="cruiseChildrenAges" class="mt-2"></div>
                                    <p class="text-sm text-gray-500">Het is de leeftijd op dag van vertrek.</p>
                                </div>
                                <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md"
                                    onclick="saveCruisePeople()">Opslaan</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="cruises-book-button"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition duration-300"
                            disabled onclick="book('cruises')">
                            Boeken
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main class="flex-grow">
        <section id="home" class="py-20">
            <div class="container mx-auto text-center">
                <h2 class="text-4xl font-bold mb-4">Discover Your Next Adventure</h2>
                <p class="text-xl mb-8">Let Travel Easy guide you to the vacation of your dreams.</p>
                <div class="space-x-4">
                    <a href="/destinations"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition duration-300">
                        Explore Destinations
                    </a>
                    <a href="/packages"
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg text-lg border border-blue-600 hover:bg-blue-50 transition duration-300">
                        View Packages
                    </a>
                </div>
            </div>
        </section>

        <div>
            <a href="{{ route('chat') }}"
                class="block w-full p-6 text-center text-white bg-[#FF2D20] rounded-lg shadow-lg hover:bg-[#FF1A00] focus:outline-none focus-visible:ring focus-visible:ring-[#FF2D20] focus-visible:ring-opacity-50">
                <span class="font-bold">Chatbot</span>
            </a>
        </div>

        <x-destinations-layout />

        <x-packages-layout />
    </main>

    <script>
        // Show the tab with the given id and hide the other tabs
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabId).classList.remove('hidden');

            document.querySelectorAll('.tab-label').forEach(label => {
                label.classList.remove('active');
            });
            document.getElementById(`${tabId}-tab`).classList.add('active');

            validateFields(tabId);
        }

        // Automatically select the flights tab when the page is loaded or refreshed
        document.addEventListener('DOMContentLoaded', function() {
            showTab('flights');
        });

        // Toggle the visibility of the dropdown with the given id
        function toggleDropdown(dropdownId) {
            document.getElementById(dropdownId).classList.toggle('hidden');
        }

        // Increment the value of the input field with the given id
        function increment(id) {
            const input = document.getElementById(id);
            let value = parseInt(input.value);
            const totalPeople = parseInt(document.getElementById('adults').value) + parseInt(document.getElementById(
                'children').value);
            if (value < 8 && totalPeople < 8) {
                input.value = value + 1;
                if (id === 'children' || id === 'cruiseChildren') {
                    addChildAgeDropdown(value + 1, id);
                }
            }
        }

        // Decrement the value of the input field with the given id
        function decrement(id) {
            const input = document.getElementById(id);
            let value = parseInt(input.value);
            if (value > 0) {
                input.value = value - 1;
                if (id === 'children' || id === 'cruiseChildren') {
                    removeChildAgeDropdown(value, id);
                }
            }
        }

        // Add a child age dropdown based on the index
        function addChildAgeDropdown(index, type) {
            const container = document.getElementById(type === 'children' ? 'children-ages' : 'cruiseChildrenAges');
            if (container.children.length === 0) {
                const infoText = document.createElement('p');
                infoText.id = 'children-info';
                infoText.className = 'font-semibold';
                infoText.innerText = 'Vul de leeftijd(en) in.*\nKinderen';
                container.appendChild(infoText);
            }
            const dropdown = document.createElement('select');
            dropdown.id = `child-age-${index}`;
            dropdown.className = 'block mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3';
            dropdown.onchange = validateAges;
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.text = 'Vul een leeftijd in';
            dropdown.appendChild(defaultOption);
            for (let age = 2; age <= 17; age++) {
                const option = document.createElement('option');
                option.value = age;
                option.text = `${age} jaar`;
                dropdown.appendChild(option);
            }
            container.appendChild(dropdown);
            validateAges();
        }

        // Remove a child age dropdown based on the index
        function removeChildAgeDropdown(index, type) {
            const dropdown = document.getElementById(`child-age-${index}`);
            if (dropdown) {
                dropdown.remove();
            }
            const container = document.getElementById(type === 'children' ? 'children-ages' : 'cruiseChildrenAges');
            if (container.children.length === 1) {
                const infoText = document.getElementById('children-info');
                if (infoText) {
                    infoText.remove();
                }
            }
            validateAges();
        }

        // Validate the ages of the children and enable the save button if all ages are valid
        function validateAges() {
            const dropdowns = document.querySelectorAll('#children-ages select, #cruiseChildrenAges select');
            const saveButton = document.querySelector(
                'button[onclick="savePeople()"], button[onclick="saveCruisePeople()"]');
            let allValid = true;
            let hasUnder16 = false;
            dropdowns.forEach(dropdown => {
                if (dropdown.value === '') {
                    allValid = false;
                }
                if (parseInt(dropdown.value) < 16) {
                    hasUnder16 = true;
                }
            });
            const adults = parseInt(document.getElementById('adults').value) || parseInt(document.getElementById(
                'cruiseAdults').value);
            if (hasUnder16 && adults === 0) {
                allValid = false;
            }
            saveButton.disabled = !allValid;
        }

        // Save the selected number of people and close the dropdown
        function savePeople() {
            const adults = document.getElementById('adults').value;
            const children = document.getElementById('children').value;
            document.getElementById('vacation_people').innerText = `${adults} volwassenen, ${children} kinderen`;
            toggleDropdown('peopleDropdown');
        }

        // Save the selected number of people for cruises and close the dropdown
        function saveCruisePeople() {
            const adults = document.getElementById('cruiseAdults').value;
            const children = document.getElementById('cruiseChildren').value;
            document.getElementById('cruise_people').innerText = `${adults} volwassenen, ${children} kinderen`;
            toggleDropdown('cruisePeopleDropdown');
        }

        // Function to validate fields and enable the "Boeken" button
        function validateFields(tabId) {
            let isValid = true;
            document.querySelectorAll(`#${tabId} input`).forEach(input => {
                if (!input.value) {
                    isValid = false;
                }
            });
            document.getElementById(`${tabId}-book-button`).disabled = !isValid;
        }

        // Redirect to the corresponding page when "Boeken" button is clicked
        function book(tabId) {
            let url = '';
            switch (tabId) {
                case 'flights':
                    const from = document.getElementById('from').value;
                    const to = document.getElementById('to').value;
                    url = `/trips?from=${from}&to=${to}`;
                    break;
                case 'vacations':
                    url = '/underdevelopment';
                    break;
                case 'cruises':
                    url = '/underdevelopment';
                    break;
            }
            window.location.href = url;
        }

        function updateDestinations() {
            const from = document.getElementById('from').value;
            fetch(`/api/destinations?departure=${from}`)
                .then(response => response.json())
                .then(data => {
                    const toSelect = document.getElementById('to');
                    toSelect.innerHTML = '<option value="">Select a destination</option>';
                    data.forEach(destination => {
                        const option = document.createElement('option');
                        option.value = destination.country;
                        option.text = destination.country;
                        toSelect.appendChild(option);
                    });
                });
        }

        function showDatePicker() {
            const dateInput = document.getElementById('date');
            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;

            if (!from || !to) {
                alert('Please select both departure and destination.');
                return;
            }

            fetch(`/api/available-dates?from=${from}&to=${to}`)
                .then(response => response.json())
                .then(data => {
                    const availableDates = data.map(date => new Date(date));
                    flatpickr(dateInput, {
                        enable: availableDates,
                        onDayCreate: function(dObj, dStr, fp, dayElem) {
                            if (availableDates.some(d => d.toDateString() === new Date(dayElem.dateObj)
                                    .toDateString())) {
                                dayElem.style.backgroundColor = 'green';
                                dayElem.style.color = 'white';
                            }
                        }
                    });
                });
        }
    </script>
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const config = {
            dateFormat: "Y-m-d",
            minDate: "2025-01-01",
            maxDate: "2026-12-31",
            locale: "nl",
            allowInput: true,
            placeholder: "Kies een datum"
        };

        flatpickr("#start_date", config);
        flatpickr("#end_date", config);
    </script>
</x-html-layout>
