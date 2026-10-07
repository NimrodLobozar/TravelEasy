<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Customer') }}
        </h2>

        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.index')">
            {{ __('Back') }}
        </x-nav-link>
    </x-slot>

    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <label for="first_name">{{ __('First Name') }}</label>
                            <input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                value="{{ old('first_name', $customer->first_name) }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="middle_name">{{ __('Middle Name') }}</label>
                            <input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
                                value="{{ old('middle_name', $customer->middle_name) }}" />
                        </div>

                        <div class="mt-4">
                            <label for="last_name">{{ __('Last Name') }}</label>
                            <input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                value="{{ old('last_name', $customer->last_name) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="username">{{ __('Username') }}</label>
                            <input id="username" class="block mt-1 w-full" type="text" name="username"
                                value="{{ old('username', $customer->username) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" class="block mt-1 w-full" type="email" name="email"
                                value="{{ old('email', $customer->email) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="mobile">{{ __('Mobile') }}</label>
                            <input id="mobile" class="block mt-1 w-full" type="text" name="mobile"
                                value="{{ old('mobile', $customer->mobile) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="address">{{ __('Address') }}</label>
                            <input id="address" class="block mt-1 w-full" type="text" name="address"
                                value="{{ old('address', $customer->address) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="city">{{ __('City') }}</label>
                            <input id="city" class="block mt-1 w-full" type="text" name="city"
                                value="{{ old('city', $customer->city) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="state">{{ __('State') }}</label>
                            <input id="state" class="block mt-1 w-full" type="text" name="state"
                                value="{{ old('state', $customer->state) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="zip">{{ __('Zip') }}</label>
                            <input id="zip" class="block mt-1 w-full" type="text" name="zip"
                                value="{{ old('zip', $customer->zip) }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="country">{{ __('Country') }}</label>
                            <input id="country" class="block mt-1 w-full" type="text" name="country"
                                value="{{ old('country', $customer->country) }}" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button class="ml-4">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
</x-app-layout>
