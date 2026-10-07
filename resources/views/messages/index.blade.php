<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Berichten') }}
            </h2>
            <label class="flex items-center">
                <span class="mr-2 text-gray-200">Toon Berichten</span>
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
            <div class="bg-green-900 border-t-4 border-green-600 rounded-b px-4 py-3 text-green-200 mb-4"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900 border-t-4 border-red-600 rounded-b px-4 py-3 text-red-200 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('messages.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nieuw Gesprek
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Conversations List -->
            <div class="bg-gray-800 rounded-lg shadow-sm border border-gray-700 p-4">
                <h2 class="text-xl font-bold text-white mb-4">Gesprekken</h2>

                @if ($conversations->isEmpty())
                    <div class="bg-yellow-900 border-t-4 border-yellow-600 rounded-b px-4 py-3 text-yellow-200">
                        Geen gesprekken gevonden.
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach ($conversations as $conv)
                            <a href="{{ route('messages.index', ['conversation_id' => $conv->id]) }}"
                                class="block p-3 rounded-lg {{ isset($conversation) && $conversation->id == $conv->id ? 'bg-blue-700' : 'bg-gray-700 hover:bg-gray-600' }}">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-white">{{ $conv->user->name ?? 'Onbekend' }}</p>
                                        @if ($conv->messages->isNotEmpty())
                                            <p class="text-sm text-gray-300 truncate">
                                                {{ $conv->messages->last()->content ?? 'Geen berichten' }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-400 italic">Geen berichten</p>
                                        @endif
                                    </div>

                                    @php
                                        $unreadCount = $conv->unreadMessagesCount(Auth::id());
                                    @endphp

                                    @if ($unreadCount > 0)
                                        <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $conv->messages->isNotEmpty() ? $conv->messages->last()->created_at->format('d M Y H:i') : $conv->created_at->format('d M Y H:i') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Messages Display -->
            <div class="bg-gray-800 rounded-lg shadow-sm border border-gray-700 p-4 md:col-span-2">
                @if (isset($conversation))
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-white">
                            Gesprek met {{ $conversation->user->name ?? 'Onbekend' }}
                        </h2>
                        {{-- Should already be correct --}}
                        <form action="{{ route('messages.destroy', $conversation) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-2 rounded"
                                onclick="return confirm('Weet je zeker dat je dit gesprek wilt verwijderen?')">
                                Verwijder Gesprek
                            </button>
                        </form>
                    </div>

                    <div class="bg-gray-700 rounded-lg p-4 h-96 overflow-y-auto mb-4">
                        @if ($conversation->messages->isEmpty())
                            <div class="text-center py-10">
                                <p class="text-gray-400 italic">Geen berichten in dit gesprek.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($conversation->messages as $message)
                                    <div
                                        class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                        <div
                                            class="{{ $message->user_id == Auth::id() ? 'bg-blue-600 text-white' : 'bg-gray-600 text-gray-200' }} 
                                                   rounded-lg px-4 py-2 max-w-[70%]">
                                            <div class="text-sm font-medium">
                                                {{ $message->user->name ?? 'Onbekend' }}
                                            </div>
                                            <div class="mt-1">{{ $message->content }}</div>
                                            <div
                                                class="text-xs {{ $message->user_id == Auth::id() ? 'text-blue-200' : 'text-gray-400' }} mt-1 text-right">
                                                {{ $message->created_at->format('d M Y H:i') }}
                                                @if ($message->user_id != Auth::id())
                                                    @if ($message->is_read)
                                                        <span class="ml-2">✓</span>
                                                    @else
                                                        <span class="ml-2">
                                                            <form
                                                                action="{{ route('messages.markAsRead', $message->id) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="text-blue-400 hover:text-blue-300">
                                                                    Markeer als gelezen
                                                                </button>
                                                            </form>
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('messages.reply', $conversation->id) }}" method="POST">
                        @csrf
                        <div class="flex">
                            <input type="text" name="content" placeholder="Schrijf een bericht..."
                                class="flex-grow bg-gray-700 text-white rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                maxlength="25" required>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r">
                                Versturen
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Max. 25 tekens</p>
                    </form>
                    {{-- In the messages display section --}}
                    @if ($conversation->messages->where('user_id', Auth::id())->isNotEmpty())
                        <div class="flex space-x-2 mt-4">
                            <form action="{{ route('messages.deleteLastMessage', $conversation) }}" method="POST">
                                @csrf
                                @method('DELETE') {{-- Add method spoofing --}}
                                <button type="submit"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm py-1 px-2 rounded"
                                    onclick="return confirm('Weet je zeker dat je je laatste bericht wilt verwijderen?')">
                                    Verwijder Laatste Bericht
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="text-center py-20">
                        <p class="text-gray-400 text-lg">Selecteer een gesprek of maak een nieuwe aan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="errorContainer" class="container mx-auto mt-8 hidden ml-64">
        <p class="text-red-500">Geen berichten gevonden.</p>
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

    // Auto-scroll to bottom of messages on page load
    document.addEventListener('DOMContentLoaded', function() {
        const messageContainer = document.querySelector('.overflow-y-auto');
        if (messageContainer) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
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
