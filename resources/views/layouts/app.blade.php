<div class="min-h-screen font-sans antialiased">
<livewire:layout.navigation />

@if (isset($header))
    <header class="bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endif

<main>
    <x-page>
        {{ $slot }}
    </x-page>
</main>
</div>
