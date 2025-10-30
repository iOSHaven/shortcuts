<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleOauthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver("google")->redirect();
    }

    public function callback()
    {
        try {
            // Get the user information from Google
            $user = Socialite::driver("google")->user();
            dd($user);
        } catch (Throwable $e) {
            return redirect(route("login"))->with(
                "error",
                "Google authentication failed.",
            );
        }
    }
}
