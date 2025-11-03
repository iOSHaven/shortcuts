<x-page>
    <div class="space-y-12">
        <x-back-button />
        <div class="prose dark:prose-invert">
            <h1>{{ $this->post->title }}</h1>
            {!! $this->post->html !!}
        </div>
    </div>

</x-page>
