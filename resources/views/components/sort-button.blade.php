@props([
    'key' => '',
    'label' => '',
])

<button wire:click="$set('sort', '{{ $key }}')" @class(['px-2 py-1 rounded', 'bg-black text-white' => $this->sort == $key, 'bg-gray-300' => $this->sort != $key])>
{{ $slot ?? $label }}
</button>
