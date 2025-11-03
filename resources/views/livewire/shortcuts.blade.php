<x-page>

    <x-page-header>
        <div class="flex items-center space-x-3">
            <h1 class="text-5xl">{{ __('Shortcuts') }}</h1>
            <a href="{{ route('shortcut.create') }}" class="flex items-center space-x-1 border border-black dark:border-white px-3 py-1">
                <span>{{ __('Add') }}</span>
                <x-heroicon-o-plus class="w-4 h-4" />
            </a>
        </div>
        <p>{{ __('Browse Apple shortcuts and add them to your phone or mac.') }}</p>
    </x-page-header>

    <x-search />

    <div class="flex space-x-3">
        <x-sort-button key="popular">{{ __('Popular') }}</x-sort-button>
        <x-sort-button key="newest">{{ __('Newest') }}</x-sort-button>
        <x-sort-button key="oldest">{{ __('Oldest') }}</x-sort-button>
        <!--<x-sort-button key="recent">Recently Updated</x-sort-button>-->
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
        @php $shortcuts = $this->shortcuts() @endphp
        @forelse($shortcuts as $shortcut)
        <div class="">
            <a href="{{ $shortcut->detailsUrl }}" class="no-underline w-full">
                <div class="flex items-center space-x-3 pointer-events-none">
                    <x-shortcut-icon :shortcut="$shortcut"/>
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
        @empty
        <div>
            {{ __('No shortcuts found.') }}
            <span>
                <a href="{{ route('shortcut.create') }}" class="inline-flex items-center space-x-1 border border-black dark:border-white px-3 py-1">
                    <span>{{ __('Add shortcut') }}</span>
                    <x-heroicon-o-plus class="w-4 h-4" />
                </a>
            </span>
        </div>
        @endforelse
    </div>
    {{ $shortcuts->links() }}
</x-page>
