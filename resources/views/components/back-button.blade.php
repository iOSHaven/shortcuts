<button x-data="back_button({
        internalDomain: '{{ parse_url(config('app.url'), PHP_URL_HOST) }}',
        fallback: '{{ route('home') }}'
    })"
    @click.prevent="back" class="space-x-2 flex items-center">
    <x-heroicon-o-chevron-left class="w-4 h-4"/>
    <span>{{ session()->get('backLabel', __('Back')) }}</span>
</button>
