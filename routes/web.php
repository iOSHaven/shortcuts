<?php

use App\Livewire\Dashboard;
use App\Livewire\Profile;
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
Route::get("/shortcut/create", ShortcutCreate::class)
    ->name("shortcut.create")
    ->middleware(["auth", "verified"]);
Route::get("/shortcut/edit/{shortcut:slug}", ShortcutEdit::class)
    ->name("shortcut.edit")
    ->middleware(["auth", "verified", "can:update,shortcut"]);
Route::get("/shortcut/{shortcut:slug}", Shortcut::class)->name("shortcut");

Route::get("dashboard", Dashboard::class)
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::get("profile", Profile::class)
    ->middleware(["auth"])
    ->name("profile");

require __DIR__ . "/auth.php";
