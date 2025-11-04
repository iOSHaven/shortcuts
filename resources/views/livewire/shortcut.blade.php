@pushOnce('meta')
    <title>{{ $this->shortcut->name }} | {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $this->shortcut->short }}">

    <meta property="og:title" content="{{ $this->shortcut->name }}">
    <meta property="og:description" content="{{ $this->shortcut->short }}">
    <meta property="og:image" content="{{ $this->shortcut->icon }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $this->shortcut->name }}">
    <meta name="twitter:description" content="{{ $this->shortcut->short }}">
    <meta name="twitter:image" content="{{ $this->shortcut->icon }}">

    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate"
                hreflang="{{ $localeCode }}"
                href="{{ LaravelLocalization::getURLFromRouteNameTranslated($localeCode, 'routes.shortcut.detail', ['shortcut' => $this->shortcut], true) }}" />
    @endforeach
@endPushOnce

<x-page>
    <div class="space-y-12">
    <x-back-button />
    <div class="flex items-center space-x-2">
        <x-shortcut-icon :shortcut="$this->shortcut"/>
        <div class="space-y-3">
            <h1 class="text-4xl">{{ $this->shortcut->name }}</h1>
            <a href="{{ $this->shortcut->downloadUrl }}" class="inline-block bg-blue-500 px-4 py-1 rounded-full text-white font-bold uppercase">GET</a>
            @can('update', $this->shortcut)
            <a href="{{ $this->shortcut->editUrl }}" class="inline-block bg-amber-400 px-4 py-1 rounded-full text-black font-bold uppercase">Edit</a>
            @endcan
        </div>
    </div>
    <div class="prose dark:prose-invert">
        {!! $this->shortcut->html !!}
    </div>
</div>
</x-page>
