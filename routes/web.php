<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Shortcuts;

Route::get("/", Shortcuts::class);

Route::view("dashboard", "dashboard")
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::view("profile", "profile")
    ->middleware(["auth"])
    ->name("profile");

require __DIR__ . "/auth.php";
