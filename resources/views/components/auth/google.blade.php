<a href="{{ route('oauth.redirect', ['provider' => 'google']) }}" class="flex items-center justify-center gap-2 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 font-medium hover:bg-gray-50 transition">
    <svg class="w-5 h-5" viewBox="0 0 533.5 544.3">
        <path fill="#4285F4" d="M533.5 278.4c0-17.4-1.6-34.1-4.6-50.3H272v95.1h147.5c-6.4 34.4-25.1 63.5-53.5 83v68h86.4c50.6-46.6 80.1-115.3 80.1-195.8z"/>
        <path fill="#34A853" d="M272 544.3c72.6 0 133.6-24 178.1-65.1l-86.4-68c-24 16.1-54.7 25.7-91.7 25.7-70.6 0-130.4-47.6-151.8-111.6H31.5v70.1C75.6 480.3 167.8 544.3 272 544.3z"/>
        <path fill="#FBBC05" d="M120.2 325.3c-10.6-31.4-10.6-65.3 0-96.7V158.5H31.5c-42.4 84.6-42.4 184.6 0 269.2l88.7-70.1z"/>
        <path fill="#EA4335" d="M272 107.7c39.5-.6 77.4 13.9 106.3 40.9l79.3-79.3C405.6 24 344.6 0 272 0 167.8 0 75.6 64 31.5 158.5l88.7 70.1C141.6 155.3 201.4 107.7 272 107.7z"/>
    </svg>

    {{ __('Sign in with Google') }}
</a>
