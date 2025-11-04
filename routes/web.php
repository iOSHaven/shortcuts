<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\SitemapController;

Route::group(
    [
        "prefix" => LaravelLocalization::setLocale(),
        "middleware" => [
            "localeSessionRedirect",
            "localizationRedirect",
            "localeViewPath",
        ],
    ],
    function () {
        require __DIR__ . "/app.php";
    },
);

Route::redirect("/apps", "/", 301);
Route::redirect("/search", "/", 301);
Route::get("sitemap.xml", SitemapController::class);

require __DIR__ . "/auth.php";
