<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class=" space-y-6">

        <x-search />

        <div class="grid grid-cols-1 divide-y">
            @php $shortcuts = $this->shortcuts() @endphp
            @forelse($shortcuts as $shortcut)
            <div class="py-1">
                <div class="flex items-center space-x-3">
                    <img src="{{ data_get($shortcut, 'icon') }}" alt="{{ data_get($shortcut, 'name') }} icon" class="h-[42px] w-[42px] rounded-lg">
                    <div class="flex-grow">
                        <div class="">{{ $shortcut->name }}</div>
                        <div class="h-4 overflow-hidden text-ellipsis text-xs">{{ $shortcut->short }}</div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ $shortcut->detailsUrl }}" class="uppercase bg-blue-400 p-3 rounded-full">
                            <x-heroicon-s-eye class="h-5 w-5"/>
                        </a>
                        <a href="{{ $shortcut->editUrl }}" class="uppercase bg-amber-400 p-3 rounded-full">
                            <x-heroicon-c-pencil-square class="h-5 w-5"/>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div>No shortcuts found. <span>
                <a href="{{ route('shortcut.create') }}" class="inline-flex items-center space-x-1 border border-black px-3 py-1">
                    <span>Add shortcut</span>
                    <x-heroicon-o-plus class="w-4 h-4" />
                </a>
            </span>
                </div>
            @endforelse
        </div>
        {{ $shortcuts->links() }}
    </div>
</x-app-layout>
