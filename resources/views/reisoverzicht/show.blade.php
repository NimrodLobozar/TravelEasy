<x-app-layout>
    <div class="min-h-screen p-6 flex items-center justify-center dark:bg-gray-900 dark:text-white">
        <div class="container max-w-screen-lg mx-auto">
            <h2 class="font-semibold text-xl text-gray-600 dark:text-gray-300">Reis Overzicht</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Details van de geselecteerde reis.</p>

            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-800">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-2">
                    <div>
                        <p class="font-medium">Vertrek Land:</p>
                        <p>{{ $reis->departure->country ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Vertrek Luchthaven:</p>
                        <p>{{ $reis->departure->airport ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Aankomst Land:</p>
                        <p>{{ $reis->destination->country ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Aankomst Luchthaven:</p>
                        <p>{{ $reis->destination->airport ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Vertrek Datum:</p>
                        <p>{{ $reis->departure_date?->format('d-m-Y') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Vertrek Tijd:</p>
                        <p>{{ substr($reis->departure_time, 0, 5) ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Aankomst Datum:</p>
                        <p>{{ $reis->arrival_date?->format('d-m-Y') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Aankomst Tijd:</p>
                        <p>{{ substr($reis->arrival_time, 0, 5) ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Status:</p>
                        <p>
                            @if($reis->is_active)
                                <span class="bg-green-400 text-white py-1 px-3 rounded-full text-xs font-medium">Actief</span>
                            @else
                                <span class="bg-red-400 text-white py-1 px-3 rounded-full text-xs font-medium">Inactief</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="font-medium">Opmerking:</p>
                        <p>{{ $reis->note ?? 'Geen opmerkingen' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>