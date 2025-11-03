@props([
    'post' => []
])
<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <div class="font-bold">{{ __('Title') }}</div>
            @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
            <input type="text" wire:model="title" placeholder="{{ __('Title') }}"
                    class="w-full border rounded p-2 dark:bg-slate-800 dark:text-white dark:border-slate-500">
        </div>

        @isset($this->slug)
            @can('modify-slugs')
                <div>
                    <div class="font-bold">{{ __('Slug') }}</div>
                    @error('slug') <p class="text-red-500">{{ $message }}</p> @enderror
                    <input type="text" wire:model="slug" placeholder="{{ __('Slug') }}"
                            class="w-full border rounded p-2 dark:bg-slate-800 dark:text-white dark:border-slate-500">
                </div>
            @endcan
        @endisset

        <div>
            <div class="font-bold">{{ __('Markdown') }}</div>
            @error('markdown') <p class="text-red-500">{{ $message }}</p> @enderror
            <x-simple-mde name="markdown" wire:model="markdown" />
        </div>

        <div class="flex items-center space-x-3">
            <button wire:loading.remove type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Submit') }}</button>
            <button wire:loading type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin"/>
            </button>
            @if ($errors->any())
                <span class="text-red-500">{{ __('Please fix errors.') }}</span>
            @endif
        </div>
    </form>
</div>

@pushOnce('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endPushOnce

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endPushOnce
