<div x-data="simple_mde({
        element: $refs.textarea,
    }, {
        content: @entangle($attributes->wire('model')),
    })" wire:ignore>
    <textarea x-ref="textarea" {{ $attributes }}></textarea>
</div>
