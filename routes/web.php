<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Shortcuts;
use App\Livewire\Shortcut;
use App\Livewire\ShortcutCreate;
use App\Livewire\ShortcutEdit;
use App\Http\Controllers\ShortcutController;

Route::get("/", Shortcuts::class)->name("shortcuts");
Route::get("/shortcut/download/{shortcut:slug}", [
    ShortcutController::class,
    "download",
])->name("shortcut.download");
Route::get("/shortcut/create", ShortcutCreate::class)->name("shortcut.create");
Route::get("/shortcut/edit/{shortcut:slug}", ShortcutEdit::class)->name(
    "shortcut.edit",
);
Route::get("/shortcut/{shortcut:slug}", Shortcut::class)->name("shortcut");

Route::view("dashboard", "dashboard")
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::view("profile", "profile")
    ->middleware(["auth"])
    ->name("profile");

require __DIR__ . "/auth.php";
