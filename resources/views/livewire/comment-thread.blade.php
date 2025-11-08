<div class="space-y-6" x-data="comment_section({highlightClass: 'bg-blue-200', duration:3500})" x-on:highlight-comment="highlight">
    <h1 class="text-4xl"> {{ __('Comments') }} </h1>
    @auth
    <div class="space-y-2">
        <textarea wire:model="comment" rows="5" class="w-full" placeholder="{{ __('Write some feedback') }}"></textarea>
        <button type="button" wire:click="postComment" class="bg-black text-white dark:bg-white dark:text-black px-3 py-1">{{ __('Post Comment') }}</button>
    </div>
    @else
    <p>{{ __('Only members can leave comments.') }} <a href="{{ route('login') }}" class="underline text-blue-500">{{ __('Sign in') }}</a></p>
    @endauth
    <div  class="space-y-3" id="comment-section" >
        @php $comments = $this->comments() @endphp
        @foreach($comments as $comment)

            <div class="space-y-2 transition-all duration-1000" id="comment-{{ $comment->id }}">
                @if($comment->parent)
                    @php $author = $comment->parent->authors->first() @endphp
                    <div wire:click="jumpToComment({{ $comment->parent_id }})" role="button" class="flex items-center space-x-2 relative ml-16 group cursor-pointer opacity-65 hover:opacity-100">
                        <div class="reply-spine dark:border-gray-500 group-hover:border-[rgba(0,0,0,0.5)] group-hover:dark:border-gray-300"></div>
                        <img src="{{ data_get($author, 'social.data.avatar') }}" alt="{{ $author->name }} avatar" class="w-6 h-6 rounded-full" />
                        <div><strong>{{ $author->name }}</strong></div>
                        <div>{{ str($comment->parent->markdown)->trim(20) }}</div>
                    </div>
                @endif
                @php $author = $comment->authors->first() @endphp
                <div class="flex items-start space-x-4">
                    <img src="{{ data_get($author, 'social.data.avatar') }}" alt="{{ $author->name }} avatar" class="w-12 h-12 rounded-full" />
                    <div class="grow">
                        <div class="space-x-2">
                            <strong>{{ $author->name }}</strong>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div>
                            <div class="prose dark:prose-invert">{!! $comment->html !!}</div>
                            @auth
                                @if($this->replyId !== $comment->id)
                                    <button class="hover:bg-gray-200 text-gray-700 hover:text-black" wire:click="$set('replyId', {{$comment->id}})">{{ __('Reply') }}</button>
                                @else
                                    <button class="hover:bg-gray-200 text-gray-700 hover:text-black" wire:click="$set('replyId', null)">{{ __('Cancel Reply') }}</button>
                                @endif
                                @if($this->replyId === $comment->id)
                                    <div class="space-y-2">
                                        <textarea wire:model="reply" rows="5" class="w-full" placeholder="{{ __('Write some feedback') }}"></textarea>
                                        <button type="button" wire:click="postReply" class="bg-black text-white dark:bg-white dark:text-black px-3 py-1">{{ __('Post Reply') }}</button>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="hover:bg-gray-200 text-gray-700 hover:text-black">{{ __('Reply') }}</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $comments->links('vendor.livewire.tailwind', ['scrollTo' => '#comment-section']) }}
    </div>
</div>
