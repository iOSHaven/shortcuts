<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;
use Throwable;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            // Get the user information from Google
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            return redirect(route("login"))->with(
                "error",
                Str::title($provider) . " authentication failed.",
            );
        }

        // Check if this social account already exists
        $account = SocialAccount::where("provider_name", $provider)
            ->where("provider_id", $socialUser->getId())
            ->first();

        if ($account) {
            $account->data = $socialUser;
            $account->save();
            // Log in the linked user
            Auth::login($account->user);
            return redirect()->intended(route("dashboard.shortcuts"));
        }

        if (Auth::check()) {
            // Link this new provider to current user
            Auth::user()
                ->socialAccounts()
                ->create([
                    "provider_name" => $provider,
                    "provider_id" => $socialUser->getId(),
                    "data" => $socialUser,
                ]);
            return redirect()
                ->intended(route("profile"))
                ->with("status", "Account linked!");
        }

        // No linked account, new user
        $user = User::create(["name" => $socialUser->getName()]);

        $social = $user->socialAccounts()->create([
            "provider_name" => $provider,
            "provider_id" => $socialUser->getId(),
            "data" => $socialUser,
        ]);

        $user->default_social = $social->id;
        $user->save();

        Auth::login($user);

        return redirect()->intended(route("dashboard.shortcuts"));
    }
}
