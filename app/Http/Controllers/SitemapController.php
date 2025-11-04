<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $shortcuts = Shortcut::search()->orderByDesc("score")->take(500)->get();

        return response()
            ->view("sitemap", compact("shortcuts"))
            ->header("Content-Type", "application/xml");
    }
}
