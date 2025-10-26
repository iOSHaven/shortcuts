<?php

namespace App\Http\Controllers;

use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function download(Shortcut $shortcut)
    {
        $shortcut->downloads += 1;
        $shortcut->save();
        return redirect($shortcut->link);
    }
}
