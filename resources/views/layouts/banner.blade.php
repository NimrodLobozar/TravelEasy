<banner class="relative overflow-hidden bg-gray-900">
    <div class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32">
        <img src="{{ asset('img/jumbo-jet-flying-sky.jpg') }}" alt=""
            class="absolute inset-0 -z-10 w-full h-full object-cover object-center">
        <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
            aria-hidden="true">
            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
        <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
            aria-hidden="true">
            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-5xl font-protest-reg tracking-tight text-white sm:text-7xl">Travel Easy</h2>
                <p class="mt-8 text-pretty text-lg font-medium text-gray-300 sm:text-xl/8">Anim aute id magna aliqua
                    ad
                    ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam
                    occaecat
                    fugiat.</p>
            </div>
            <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
                <div
                    class="grid grid-cols-1 gap-x-8 gap-y-6 text-base/7 font-semibold text-white sm:grid-cols-2 md:flex lg:gap-x-10">
                    <a href="#">Open roles <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Internship program <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Our values <span aria-hidden="true">&rarr;</span></a>
                    <a href="#">Meet our leadership <span aria-hidden="true">&rarr;</span></a>
                </div>
                <dl class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Offices worldwide</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">12</dd>
                    </div>
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Travel advices</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">300+</dd>
                    </div>
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Days per year</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">365</dd>
                    </div>
                    <div class="flex flex-col-reverse gap-1">
                        <dt class="text-base/7 text-gray-300">Paid time off</dt>
                        <dd class="text-4xl font-semibold tracking-tight text-white">Unlimited</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <x-search-layout />
    {{-- <div
        class="absolute inset-0 mr-64 ml-64 mt-16 h-64 top-full transform -translate-y-1/2 custom-shadow rounded-b-3xl">
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
                    <div class="flex justify-around p-6">
                        <div class="w-64 mb-6">
                            <x-input-label for="from" :value="__('Van')" />
                            <select id="from" class="block mt-1 w-full" name="from" required
                                oninput="validateFields('flights')">
                                @foreach ($departures as $departure)
                                    <option value="{{ $departure->id }}">{{ $departure->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="to" :value="__('Naar')" />
                            <select>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination->id }}">{{ $destination->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="date" :value="__('Waneer')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                required oninput="validateFields('flights')" />
                        </div>
                        <div class="w-64 mb-6">
                            <x-input-label for="return_date" :value="__('Terug')" />
                            <x-text-input id="return_date" class="block mt-1 w-full" type="date" name="return_date"
                                oninput="validateFields('flights')" />
                        </div>
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
                            <x-text-input id="destination" class="block mt-1 w-full" type="text"
                                name="destination" oninput="validateFields('vacations')" />
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
    </div> --}}
</banner>
