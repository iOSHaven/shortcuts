<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function download(Shortcut $shortcut)
    {
        metric("downloads")->measurable($shortcut)->hourly()->record();
        return redirect($shortcut->link);
    }
}
