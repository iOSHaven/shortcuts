<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        "prefix" => LaravelLocalization::setLocale(),
        "middleware" => [
            "guest",
            "localeSessionRedirect",
            "localizationRedirect",
            "localeViewPath",
        ],
    ],
    function () {
        Volt::route(
            LaravelLocalization::transRoute("routes.login"),
            "pages.auth.login",
        )->name("login");
    },
);

// Route to redirect to the social media's OAuth page
Route::get("/oauth/{provider}/redirect", [
    SocialAuthController::class,
    "redirect",
])->name("oauth.redirect");

// Route to handle the callback from social media
Route::get("/oauth/{provider}/callback", [
    SocialAuthController::class,
    "callback",
])->name("oauth.callback");
