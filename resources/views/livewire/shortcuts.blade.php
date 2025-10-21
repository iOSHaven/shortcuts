<div class="space-y-6">
    <div class="space-y-3">
        <h1 class="text-5xl">Shortcuts</h1>
        <p>Browse Apple shortcuts and add them to your phone or mac.</p>
    </div>

    <div>
        <input
            type="text"
            placeholder="Search..."
            wire:model.live.debounce.300ms="search"
            class="border rounded px-2 py-3 w-full"
        />
    </div>

    <div class="flex space-x-3">
        <x-sort-button key="popular">Popular</x-sort-button>
        <x-sort-button key="newest">Newest</x-sort-button>
        <x-sort-button key="oldest">Oldest</x-sort-button>
        <!--<x-sort-button key="recent">Recently Updated</x-sort-button>-->
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
        @php $shortcuts = $this->shortcuts() @endphp
        @foreach($shortcuts as $shortcut)
        <div class="">
            <a href="#" class="no-underline w-full">
                <div class="flex items-center space-x-3 pointer-events-none">
                    <img src="{{ $shortcut->icon }}" alt="{{ $shortcut->name }} icon" class="h-[77px] w-[77px] rounded-xl">
                    <div class="flex-grow">
                        <div class="text-2xl">{{ $shortcut->name }}</div>
                        <div class="h-6 overflow-hidden text-ellipsis">{{ $shortcut->short }}</div>
                    </div>
                    <div>
                        <x-heroicon-o-chevron-right class="w-8 h-8"/>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    {{ $shortcuts->links() }}
</div>
