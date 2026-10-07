<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Register Customer') }}
            </h2>
        </div>
    </x-slot>
    <div id="dataContainer" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        {{ __('Register Customer') }}
                    </div>
                    <div class="mt-6 text-gray-500">
                        {{ __('Fill in the form below to register a new customer.') }}
                    </div>

                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="space-y-4">
                                <div>
                                    <!-- First Name -->
                                    <x-input-label-create for="first_name" :value="__('First Name')" />
                                    <x-text-input-login-reg id="first_name" class="block mt-1 w-full" type="text"
                                        name="first_name" :value="old('first_name')" required autofocus
                                        autocomplete="first_name" />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <div>
                                    <!-- Middle Name -->
                                    <x-input-label-create for="middle_name" :value="__('Middle Name')" />
                                    <x-text-input-login-reg id="middle_name" class="block mt-1 w-full" type="text"
                                        name="middle_name" :value="old('middle_name')" autocomplete="middle_name" />
                                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                                </div>

                                <div>
                                    <!-- Last Name -->
                                    <x-input-label-create for="last_name" :value="__('Last Name')" />
                                    <x-text-input-login-reg id="last_name" class="block mt-1 w-full" type="text"
                                        name="last_name" :value="old('last_name')" required autocomplete="last_name" />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>

                                <div>
                                    <!-- Username -->
                                    <x-input-label-create for="username" :value="__('Username')" />
                                    <x-text-input-login-reg id="username" class="block mt-1 w-full" type="text"
                                        name="username" :value="old('username')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <!-- Email Address -->
                                    <x-input-label-create for="email" :value="__('Email')" />
                                    <x-text-input-login-reg id="email" class="block mt-1 w-full" type="email"
                                        name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <!-- Phone Number -->
                                    <x-input-label-create for="mobile" :value="__('Phone Number')" />
                                    <x-text-input-login-reg id="mobile" class="block mt-1 w-full" type="text"
                                        name="mobile" :value="old('mobile')" required autocomplete="mobile" />
                                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                                </div>

                                <div>
                                    <!-- Password -->
                                    <x-input-label-create for="password" :value="__('Password')" />
                                    <x-text-input-login-reg id="password" class="block mt-1 w-full" type="password"
                                        name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <!-- Confirm Password -->
                                    <x-input-label-create for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input-login-reg id="password_confirmation" class="block mt-1 w-full"
                                        type="password" name="password_confirmation" required
                                        autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('customers.index') }}"
                                class="underline text-sm-4 text-red-900 hover:text-red-600">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
