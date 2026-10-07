<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Customer Overview') }}
        </h2>
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4">
            <label class="flex items-center">
                <span class="mr-2 text-white-900 toon">Toon Data</span>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" id="dataToggle"
                        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                        checked />
                    <label for="dataToggle"
                        class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </label>

            <div class="ml-auto">
                <input type="text" id="search" name="search" placeholder="Search..."
                    class="border border-gray-300 p-2 rounded-l-lg focus:outline-none focus:ring focus:border-blue-300" />
                <button id="searchButton"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-r-lg transition duration-300 hover:bg-green-700 transform hover:scale-105 -ml-1">Search</button>
            </div>

            <a href="{{ route('customers.create') }}"
                class="bg-green-600 text-white px-5 py-2.5 rounded-lg transition duration-300 hover:bg-green-700 transform hover:scale-105">
                Add New Customer
            </a>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4">
                <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                First Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Infix
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Relationship Number
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $customer->first_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $customer->middle_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $customer->last_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $customer->relation_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $customer->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="md:hidden">
                    @foreach ($customers as $customer)
                        <div class="border rounded-lg mb-4">
                            <button class="w-full text-left px-4 py-2 bg-gray-200"
                                onclick="toggleDropdown({{ $customer->id }})">
                                {{ $customer->last_name }}
                            </button>
                            <div id="dropdown-{{ $customer->id }}" class="hidden px-4 py-2">
                                <p><strong>First Name:</strong> {{ $customer->first_name }}</p>
                                <p><strong>Infix:</strong> {{ $customer->middle_name }}</p>
                                <p><strong>Relationship Number:</strong> {{ $customer->relation_number }}</p>
                                <p><strong>Email:</strong> {{ $customer->email }}</p>
                                <div class="mt-2">
                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen klanten gevonden. Probeer later opnieuw.</p>
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

    function performSearch() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        const pagination = document.querySelector('.mt-4');
        const errorContainer = document.getElementById('errorContainer');
        const dataContainer = document.getElementById('dataContainer');
        const dropdowns = document.querySelectorAll('.md\\:hidden > div');

        let hasResults = false;
        rows.forEach(row => {
            const lastName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            if (lastName.includes(searchValue)) {
                row.classList.remove('hidden');
                hasResults = true;
            } else {
                row.classList.add('hidden');
            }
        });

        dropdowns.forEach(dropdown => {
            const lastName = dropdown.querySelector('button').textContent.toLowerCase();
            if (lastName.includes(searchValue)) {
                dropdown.classList.remove('hidden');
                hasResults = true;
            } else {
                dropdown.classList.add('hidden');
            }
        });

        if (searchValue === '') {
            pagination.classList.remove('hidden');
            errorContainer.classList.add('hidden');
            dataContainer.classList.remove('hidden');
        } else if (hasResults) {
            pagination.classList.add('hidden');
            errorContainer.classList.add('hidden');
            dataContainer.classList.remove('hidden');
        } else {
            pagination.classList.add('hidden');
            errorContainer.classList.remove('hidden');
            dataContainer.classList.add('hidden');
        }
    }

    document.getElementById('searchButton').addEventListener('click', performSearch);

    document.getElementById('search').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            performSearch();
        }
    });

    function toggleDropdown(id) {
        const dropdown = document.getElementById(`dropdown-${id}`);
        dropdown.classList.toggle('hidden');
    }
</script>
<style>
    h2 {
        color: #fff;
    }

    .toon {
        color: #fff;
    }

    .toggle-checkbox:checked {
        right: 0;
        border-color: #38A169;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #38A169;
    }
</style>
