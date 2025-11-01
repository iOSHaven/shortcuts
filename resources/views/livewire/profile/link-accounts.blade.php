<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;

new class extends Component {
    public $google;
    public $facebook;
    public $twitter;

    public function mount()
    {
        $this->refreshAccounts();
    }

    public function refreshAccounts()
    {
        $accounts = Auth::user()->socialAccounts()->get();
        $this->google = $accounts->where("provider_name", "google")->first();
        $this->twitter = $accounts->where("provider_name", "twitter")->first();
        $this->facebook = $accounts
            ->where("provider_name", "facebook")
            ->first();
    }

    public function deleteSocial($id)
    {
        $account = Auth::user()->socialAccounts()->find($id);
        if ($account) {
            if (Auth::user()->socialAccounts()->count() > 1) {
                $account->delete();
                $this->refreshAccounts();
            } else {
                throw ValidationException::withMessages([
                    "delete" => "Must have at least one account",
                ]);
            }
        } else {
            throw ValidationException::withMessages([
                "delete" => "Account not found.",
            ]);
        }
    }
};
?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Link Accounts') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Link additional accounts to use for login.") }}
        </p>

        @error('delete')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </header>

    <div class="space-y-3">

        @if($this->google)
            <div>
                <div class="font-bold">Google</div>
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img src="{{ data_get($this->google, 'data.avatar') }}" alt="Google avatar" class="h-10 w-10 rounded-full" />
                        <span>{{ data_get($this->google, 'data.name') }}</span>
                    </div>
                    <button type="button" wire:click="deleteSocial({{ $this->google->id }})" class="px-3 py-1 bg-red-500 rounded-lg text-white">
                        Unlink Gooogle
                    </button>
                </div>
            </div>
        @else
            <x-auth.google />
        @endif

        @if($this->twitter)
            <div>
                <div class="font-bold">X</div>
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img src="{{ data_get($this->twitter, 'data.avatar') }}" alt="X avatar" class="h-10 w-10 rounded-full" />
                        <span>{{ data_get($this->twitter, 'data.name') }}</span>
                    </div>
                    <button type="button" wire:click="deleteSocial({{ $this->twitter->id }})" class="px-3 py-1 bg-red-500 rounded-lg text-white">
                        Unlink X
                    </button>
                </div>
            </div>
        @else
            <x-auth.twitter />
        @endif

        @if($this->facebook)
            <div>
                <div class="font-bold">Facebook</div>
                <div class="flex items-center justify-between space-x-2">
                    <div class="flex items-center space-x-2">
                        <img src="{{ data_get($this->facebook, 'data.avatar') }}" alt="Facebook avatar" class="h-10 w-10 rounded-full" />
                        <span>{{ data_get($this->facebook, 'data.name') }}</span>
                    </div>
                    <button type="button" wire:click="deleteSocial({{ $this->facebook->id }})" class="px-3 py-1 bg-red-500 rounded-lg text-white">
                        Unlink Facebook
                    </button>
                </div>
            </div>
        @else
            <x-auth.facebook />
        @endif
    </div>
</section>
