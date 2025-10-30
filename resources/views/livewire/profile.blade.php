<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Link Accounts') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Link additional accounts to use for login.") }}
                            </p>
                        </header>

                        <div class="space-y-3">

                            @php
                                $accounts = Auth::user()->socialAccounts()->get();
                                $google = $accounts->where('provider_name', 'google')->first();
                                $twitter = $accounts->where('provider_name', 'twitter')->first();
                                $facebook = $accounts->where('provider_name', 'facebook')->first();
                            @endphp

                            @if($google)
                                <div class="flex items-center space-x-2">
                                    <span>Google:</span>
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ data_get($google, 'data.avatar') }}" alt="Google avatar" class="h-10 w-10 rounded-full" />
                                        <span>{{ data_get($google, 'data.name') }}</span>
                                    </div>
                                </div>
                            @else
                                <x-auth.google />
                            @endif

                            @if($twitter)
                                <div class="flex items-center space-x-2">
                                    <span>X:</span>
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ data_get($twitter, 'data.avatar') }}" alt="X avatar" class="h-10 w-10 rounded-full" />
                                        <span>{{ data_get($twitter, 'data.name') }}</span>
                                    </div>
                                </div>
                            @else
                                <x-auth.twitter />
                            @endif

                            @if($facebook)
                                <div class="flex items-center space-x-2">
                                    <span>Facebook:</span>
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ data_get($facebook, 'data.avatar') }}" alt="Facebook avatar" class="h-10 w-10 rounded-full" />
                                        <span>{{ data_get($facebook, 'data.name') }}</span>
                                    </div>
                                </div>
                            @else
                                <x-auth.facebook />
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
