<div class="flex items-start justify-between">
    <div class="space-y-3">
        {{ $slot }}
    </div>
    <div class="flex items-center">
        @auth
        <a href="{{ route('dashboard') }}">Dashboard</a>
        @else
        <a href="{{ route('login') }}">Login</a>
        @endauth
    </div>
</div>
