@props([
    'shortcut' => [],
    'step' => 1
])
<div>
    @if ($step === 1)
        <form wire:submit.prevent="next" class="space-y-2">
            <input type="url" wire:model="icloud_url" placeholder="Enter iCloud link"
                    class="w-full border rounded p-2">
            @error('icloud_url') <p class="text-red-500">{{ $message }}</p> @enderror
            <button wire:loading.remove type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
            <button wire:loading type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin"/>
            </button>
        </form>
    @else
    <form wire:submit.prevent="save" class="space-y-2">
        <div>
            <div class="font-bold">Name</div>
            <span>{{ data_get($shortcut, 'name') }}</span>
        </div>
        <div>
            <div class="font-bold">Icon</div>
            <x-shortcut-icon :shortcut="$shortcut" />
        </div>
        <div>
            <div class="font-bold">Description</div>
            @error('description') <p class="text-red-500">{{ $message }}</p> @enderror
            <x-simple-mde name="markdown" wire:model="description" />
        </div>
        <button wire:loading.remove type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
        <button wire:loading type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
            <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin"/>
        </button>
    </form>
    @endif
</div>

@pushOnce('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endPushOnce

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endPushOnce
