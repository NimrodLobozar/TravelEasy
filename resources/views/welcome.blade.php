<x-html-layout>
    <x-banner-layout />

    <main class="flex-grow mt-40">
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
                    url = '/underdevelopment';
                    // url = '/flights';
                    break;
                case 'vacations':
                    url = '/underdevelopment';
                    // url = '/vacations';
                    break;
                case 'cruises':
                    url = '/underdevelopment';
                    // url = '/cruises';
                    break;
            }
            window.location.href = url;
        }
    </script>
</x-html-layout>
