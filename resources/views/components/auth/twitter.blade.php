<a href="{{ route('oauth.redirect', ['provider' => 'twitter']) }}" class="flex items-center justify-center gap-2 w-full rounded-lg bg-black px-4 py-2 text-white font-medium hover:bg-neutral-900 transition">
    {{ __('Sign in with') }}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
        <path d="M18.244 2H21.5l-7.59 8.68L22 22h-6.63l-5.2-6.9L3.99 22H.73l8.06-9.21L2 2h6.63l4.71 6.29L18.24 2zm-2.32 18h1.73L7.23 3.99H5.36L15.92 20z"/>
    </svg>
</a>
