<?php

use App\Livewire\Dashboard;
use App\Livewire\DashboardPosts;
use App\Livewire\Profile;
use App\Livewire\HowToDelete;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Livewire\Shortcuts;
use App\Livewire\Shortcut;
use App\Livewire\ShortcutCreate;
use App\Livewire\ShortcutEdit;
use App\Livewire\PostCreate;
use App\Livewire\PostEdit;
use App\Livewire\PostDetail;
use App\Http\Controllers\ShortcutController;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get("/", Shortcuts::class)->name("home");

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
    LaravelLocalization::transRoute("routes.post.create"),
    PostCreate::class,
)
    ->name("post.create")
    ->middleware(["auth", "verified", "can:create,App\\Models\\Post"]);

Route::get(
    LaravelLocalization::transRoute("routes.shortcut.edit"),
    ShortcutEdit::class,
)
    ->name("shortcut.edit")
    ->middleware(["auth", "verified", "can:update,shortcut"]);

Route::get(LaravelLocalization::transRoute("routes.post.edit"), PostEdit::class)
    ->name("post.edit")
    ->middleware(["auth", "verified", "can:update,post"]);

Route::get(
    LaravelLocalization::transRoute("routes.shortcut.detail"),
    Shortcut::class,
)->name("shortcut.detail");

Route::get(
    LaravelLocalization::transRoute("routes.post.detail"),
    PostDetail::class,
)->name("post.detail");

Route::get(
    LaravelLocalization::transRoute("routes.dashboard.shortcuts"),
    Dashboard::class,
)
    ->middleware(["auth", "verified"])
    ->name("dashboard.shortcuts");

Route::get(
    LaravelLocalization::transRoute("routes.dashboard.posts"),
    DashboardPosts::class,
)
    ->middleware(["auth", "verified", "can:crud-posts"])
    ->name("dashboard.posts");

Route::get(LaravelLocalization::transRoute("routes.profile"), Profile::class)
    ->middleware(["auth"])
    ->name("profile");

Route::get(LaravelLocalization::transRoute("routes.how-to-delete"), function (
    Request $request,
) {
    return Post::renderDetail("how-to-delete");
})->name("how-to-delete");

Route::get(LaravelLocalization::transRoute("routes.privacy-policy"), function (
    Request $request,
) {
    return Post::renderDetail("privacy-policy");
})->name("privacy-policy");

Route::get(LaravelLocalization::transRoute("routes.tos"), function (
    Request $request,
) {
    return Post::renderDetail("terms-of-service");
})->name("tos");
