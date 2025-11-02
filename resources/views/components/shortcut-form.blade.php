@props([
    'shortcut' => [],
    'step' => 1
])
<div>
    @if ($step === 1)
        <form wire:submit.prevent="next" class="space-y-2">
            <div>{{ __('iCloud Link') }}</div>
            <input type="url" wire:model="icloud_url" placeholder="https://www.icloud.com/shortcuts/6bf870eaa5904dbd8bcc53868eebacd2"
                    class="w-full border rounded p-2 dark:bg-slate-800 dark:text-white dark:border-slate-500">
            @error('icloud_url') <p class="text-red-500">{{ $message }}</p> @enderror
            <div class="flex items-center space-x-3">
                <button wire:loading.remove type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Next') }}</button>
                <button wire:loading type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                    <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin"/>
                </button>
                @if ($errors->any())
                    <span class="text-red-500">{{ __('Please fix errors.') }}</span>
                @endif
            </div>
        </form>
    @else
    <form wire:submit.prevent="save" class="space-y-2">
        <div>
            <div class="font-bold">{{ __('Name') }}</div>
            <span>{{ data_get($shortcut, 'name') }}</span>
        </div>
        <div>
            <div class="font-bold">{{ __('Icon') }}</div>
            <x-shortcut-icon :shortcut="$shortcut" />
        </div>
        <div>
            <div class="font-bold">{{ __('Short Description') }}</div>
            @error('short') <p class="text-red-500">{{ $message }}</p> @enderror
            <input name="short" wire:model="short" type="text" class="w-full rounded border-gray-300 dark:bg-slate-800 dark:text-white dark:border-slate-500" placeholder="{{ __('A cool shortcut that let\'s you do things.') }}" />
        </div>
        <div>
            <div class="font-bold">{{ __('Description') }}</div>
            @error('description') <p class="text-red-500">{{ $message }}</p> @enderror
            <x-simple-mde name="markdown" wire:model="description" />
        </div>
        <div class="flex items-center space-x-3">
            <button wire:loading.remove type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Submit') }}</button>
            <button wire:loading type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin"/>
            </button>
            @if ($errors->any())
                <span class="text-red-500">{{ __('Please fix errors.') }}</span>
            @endif
            <div
                x-data="{ show: @entangle('saved') }"
                x-show="show"
                x-transition
                x-init="$watch('show', () => {setTimeout(() => show = false, 3000)})"
                class="text-green-600 mt-2"
            >
                {{ __('Saved.') }}
            </div>
        </div>

    </form>
    @endif
</div>

@pushOnce('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endPushOnce

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endPushOnce
