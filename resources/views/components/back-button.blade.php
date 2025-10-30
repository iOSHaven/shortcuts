<button x-data="back_button({
        internalDomain: '{{ parse_url(config('app.url'), PHP_URL_HOST) }}',
        fallback: '{{ route('shortcuts') }}'
    })"
    @click.prevent="back" class="space-x-2 flex items-center">
    <x-heroicon-o-chevron-left class="w-4 h-4"/>
    <span>Back</span>
</button>
