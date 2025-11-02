<div
    x-data
    x-on:replace-location.window="(() => { sessionStorage.setItem('backOverride', $event.detail.back); window.location.replace($event.detail.url); })()"
>
    <select wire:model.live="locale" class="border rounded px-2 py-1 dark:bg-slate-800">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <option value="{{ $localeCode }}" {{ $locale === $localeCode ? 'selected' : '' }}>{{ $properties['native'] }}</option>
        @endforeach
    </select>
</div>
