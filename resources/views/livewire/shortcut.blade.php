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
