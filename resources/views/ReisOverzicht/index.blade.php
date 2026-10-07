<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white-900 leading-tight">
                {{ __('Reis Overzicht') }}
            </h2>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
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
                <a href="{{ route('reisoverzicht.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-md transition duration-300 hover:bg-green-700 transform hover:scale-105">Reis Toevoegen</a>
            </div>
        </div>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Reis List -->
                <div class="w-full overflow-x-auto">
                    <div class="bg-white shadow-lg rounded-lg my-6">
                        @if (session('success'))
                            <div class="bg-green-100 border-t-4 border-green-600 rounded-b px-4 py-3 text-green-700" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($reizen->count() > 0)
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-sm font-medium leading-normal">
                                        <th class="py-4 px-6 text-left">Land</th>
                                        <th class="py-4 px-6 text-left">Luchthaven</th>
                                        <th class="py-4 px-6 text-left">Status</th>
                                        <th class="py-4 px-6 text-center">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 text-sm font-light">
                                    @foreach ($reizen as $reis)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium">{{ $reis->departure->country ?? 'N/A' }}</td>
                                            <td class="py-3 px-6 text-left">{{ $reis->departure->airport ?? 'N/A' }}</td>
                                            <td class="py-3 px-6 text-left">
                                                @if($reis->is_active)
                                                    <span class="bg-green-400 text-white py-1 px-3 rounded-full text-xs font-medium">Actief</span>
                                                @else
                                                    <span class="bg-red-400 text-white py-1 px-3 rounded-full text-xs font-medium">Inactief</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <!-- Acties -->
                                                <a href="{{ route('reisoverzicht.show', $reis->id) }}" class="text-blue-500 hover:text-blue-700">ⓘ</a>
                                                <a href="{{ route('reisoverzicht.edit', $reis->id) }}" class="text-yellow-500 hover:text-yellow-700 ml-2">✎</a>
                                                <form action="{{ route('reisoverzicht.destroy', $reis->id) }}" method="POST" class="inline-block ml-2" onsubmit="return customConfirm(event, this);">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">🗑️</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-red-500 p-4">Geen reizen gevonden.</p>
                        @endif
                    </div>
  
                </div>
            </div>
        </div>
    </div>

    <div id="errorContainer" class="py-12 hidden ml-64">
        <p class="text-red-500">Geen reizen gevonden. Probeer later opnieuw.</p>
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

    function customConfirm(event, form) {
        event.preventDefault();
        const message = 'Weet je zeker dat je deze reis wilt verwijderen?';
        const confirmation = confirm(message);

        if (confirmation) {
            const unhappy = confirm('Klik op OK voor verwijderen of Annuleren voor Unhappy.');
            if (unhappy) {
                form.submit();
            } else {
                alert('Internet fout, probeer het later opnieuw');
            }
        }
        return false;
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
