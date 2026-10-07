<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Nieuw Gesprek Starten') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-sm border border-gray-700 p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Start een Nieuw Gesprek</h1>
            
            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="content" class="block text-gray-200 text-sm font-medium mb-2">
                        Eerste Bericht
                    </label>
                    <textarea name="content" id="content" 
                        class="bg-gray-700 text-white rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="4" 
                        placeholder="Schrijf je eerste bericht..." 
                        maxlength="25"
                        required>{{ old('content') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Max. 25 tekens</p>
                </div>

                <div class="mb-6 mt-2 flex items-center">
                    <input type="checkbox" name="simulate_error" id="simulate_error" class="mr-2 h-4 w-4 rounded border-gray-600 bg-gray-700 text-blue-600 focus:ring-blue-500">
                    <label for="simulate_error" class="text-sm text-gray-400">
                        Simuleer server fout. Alleen voor developers.
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('messages.index') }}" 
                       class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                        Annuleren
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Gesprek Starten
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>