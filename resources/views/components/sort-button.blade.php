@props([
    'key' => '',
    'label' => '',
])

<button wire:click="$set('sort', '{{ $key }}')" @class(['px-2 py-1 rounded', 'bg-black text-white dark:bg-white dark:text-black' => $this->sort == $key, 'bg-gray-300 dark:bg-gray-700' => $this->sort != $key])>
{{ $slot ?? $label }}
</button>
