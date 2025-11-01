<div class="flex items-center space-x-2 border rounded w-full pl-3 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-none">
    <x-heroicon-o-magnifying-glass class="w-4 h-4 text-gray-500" />
    <input
        type="text"
        placeholder="{{ __('Search') }}..."
        name="search"
        wire:model.live.debounce.300ms="search"
        class="border-none dark:bg-slate-800 dark:text-white px-2 py-3 w-full rounded focus:ring-0 focus:outline-none"
    />
</div>
