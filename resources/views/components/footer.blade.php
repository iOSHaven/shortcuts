<footer class="space-y-6 text-center py-12">
    <hr />
    <p>iOS Haven. {{ __('All rights reserved.') }} &copy; {{ now()->year }}</p>
    <div class="flex items-center divide-x justify-center">
        <a href="{{ route('tos') }}" class="px-3 underline text-blue-500">Terms of Service</a>
        <a href="{{ route('privacy-policy') }}" class="px-3 underline text-blue-500">Privacy Policy</a>
    </div>
    <livewire:locale-switcher/>
</footer>
