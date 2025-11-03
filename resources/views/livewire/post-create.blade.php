<x-page>
    <div class="space-y-6">
    <x-back-button />
    <div class="space-y-3">
        <div class="flex items-center space-x-3">
            <h1 class="text-5xl">{{ __('Create Post') }}</h1>
        </div>
    </div>

    <x-post-form :post="['title' => $this->title, 'markdown' => $this->markdown, ]"/>
</div>
</x-page>
