<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }}
            </h2>
            <a href="{{ route('post.create') }}" class="inline-flex items-center space-x-1 border border-black dark:border-white px-3 py-1">
                <span>{{ __('Add post') }}</span>
                <x-heroicon-o-plus class="w-4 h-4" />
            </a>
        </div>
    </x-slot>

    <div class=" space-y-6">

        <x-search />

        <div class="grid grid-cols-1 divide-y">
            @php $posts = $this->posts() @endphp
            @forelse($posts as $post)
            <div class="py-1">
                <div class="flex items-center space-x-3">
                    @if(data_get($post, 'thumbnail'))
                        <img src="{{ data_get($post, 'thumbnail') }}" alt="{{ data_get($post, 'name') }} thumbnail" class="h-[42px] w-[42px]">
                    @else
                        <div class="h-[42px] w-[42px] bg-gray-100"></div>
                    @endif
                    <div class="flex-grow">
                        <div class="">{{ $post->title }}</div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ $post->detailsUrl }}" class="uppercase bg-blue-400 p-3 rounded-full">
                            <x-heroicon-s-eye class="h-5 w-5"/>
                        </a>
                        <a href="{{ $post->editUrl }}" class="uppercase bg-amber-400 p-3 rounded-full">
                            <x-heroicon-c-pencil-square class="h-5 w-5"/>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div>
                {{ __('No posts found.') }}
                <span>
                    <a href="{{ route('post.create') }}" class="inline-flex items-center space-x-1 border border-black dark:border-white px-3 py-1">
                        <span>{{ __('Add post') }}</span>
                        <x-heroicon-o-plus class="w-4 h-4" />
                    </a>
                </span>
            </div>
            @endforelse
        </div>
        {{ $posts->links() }}
    </div>
</x-app-layout>
