<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware("guest")->group(function () {
    // Volt::route('register', 'pages.auth.register')
    //     ->name('register');

    Volt::route("login", "pages.auth.login")->name("login");

    // Volt::route('forgot-password', 'pages.auth.forgot-password')
    //     ->name('password.request');

    // Volt::route('reset-password/{token}', 'pages.auth.reset-password')
    //     ->name('password.reset');
});

// Route to redirect to Google's OAuth page
Route::get("/oauth/{provider}/redirect", [
    SocialAuthController::class,
    "redirect",
])->name("oauth.redirect");

// Route to handle the callback from Google
Route::get("/oauth/{provider}/callback", [
    SocialAuthController::class,
    "callback",
])->name("oauth.callback");

// Route::middleware('auth')->group(function () {
//     Volt::route('verify-email', 'pages.auth.verify-email')
//         ->name('verification.notice');

//     Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//         ->middleware(['signed', 'throttle:6,1'])
//         ->name('verification.verify');

//     Volt::route('confirm-password', 'pages.auth.confirm-password')
//         ->name('password.confirm');
// });
