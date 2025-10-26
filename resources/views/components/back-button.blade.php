@php
    $previousUrl = url()->previous();
    if (!str($previousUrl)->contains(config('app.url')) || $previousUrl == url()->current()) {
        $previousUrl = route('shortcuts');
    }
@endphp

<a href="{{ $previousUrl }}" class="space-x-2 flex items-center">
    <x-heroicon-o-chevron-left class="w-4 h-4"/>
    <span>Back</span>
</a>
