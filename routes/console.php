<?php

use App\Console\Commands\UpdateShortcutMetrics;
use Illuminate\Support\Facades\Schedule;

Schedule::command(UpdateShortcutMetrics::class)->everyThirtyMinutes();
