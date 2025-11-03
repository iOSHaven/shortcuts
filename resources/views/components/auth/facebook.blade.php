<a href="{{ route('oauth.redirect', ['provider' => 'facebook']) }}" class="flex items-center justify-center gap-2 w-full rounded-lg bg-[#1877F2] px-4 py-2 text-white font-medium hover:bg-[#166fe5] transition">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
        <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.351C0 23.4.6 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.657-4.788 1.325 0 2.464.099 2.797.143v3.243l-1.921.001c-1.506 0-1.797.716-1.797 1.764v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.4 24 24 23.4 24 22.676V1.325C24 .6 23.4 0 22.675 0z"/>
    </svg>
    {{ __('Connect with Facebook') }}
</a>
