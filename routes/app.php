<?php

use App\Livewire\Dashboard;
use App\Livewire\Profile;
use App\Livewire\HowToDelete;
use Illuminate\Support\Facades\Route;
use App\Livewire\Shortcuts;
use App\Livewire\Shortcut;
use App\Livewire\ShortcutCreate;
use App\Livewire\ShortcutEdit;
use App\Http\Controllers\ShortcutController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get("/", Shortcuts::class)->name("shortcuts");

Route::get(LaravelLocalization::transRoute("routes.shortcut.download"), [
    ShortcutController::class,
    "download",
])->name("shortcut.download");

Route::get(
    LaravelLocalization::transRoute("routes.shortcut.create"),
    ShortcutCreate::class,
)
    ->name("shortcut.create")
    ->middleware(["auth", "verified"]);

Route::get(
    LaravelLocalization::transRoute("routes.shortcut.edit"),
    ShortcutEdit::class,
)
    ->name("shortcut.edit")
    ->middleware(["auth", "verified", "can:update,shortcut"]);

Route::get(
    LaravelLocalization::transRoute("routes.shortcut.detail"),
    Shortcut::class,
)->name("shortcut");

Route::get(
    LaravelLocalization::transRoute("routes.dashboard"),
    Dashboard::class,
)
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::get(LaravelLocalization::transRoute("routes.profile"), Profile::class)
    ->middleware(["auth"])
    ->name("profile");

Route::get(
    LaravelLocalization::transRoute("routes.how-to-delete"),
    HowToDelete::class,
);
