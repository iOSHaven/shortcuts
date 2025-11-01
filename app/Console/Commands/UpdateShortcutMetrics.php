<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shortcut;
use DirectoryTree\Metrics\Metric;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateShortcutMetrics extends Command
{
    protected $signature = "metrics:update-shortcuts";
    protected $description = "Aggregate metric data into the shortcuts table hourly.";

    public function handle()
    {
        $this->info("Updating shortcut metrics...");

        $now = now();
        $since24 = $now->copy()->subDay();

        // Fetch all-time aggregates
        $allTimeViews = Metric::query()
            ->where("name", "shortcut:views")
            ->where("measurable_type", Shortcut::class)
            ->selectRaw("measurable_id, SUM(value) as total")
            ->groupBy("measurable_id")
            ->pluck("total", "measurable_id");

        $allTimeDownloads = Metric::query()
            ->where("name", "shortcut:downloads")
            ->where("measurable_type", Shortcut::class)
            ->selectRaw("measurable_id, SUM(value) as total")
            ->groupBy("measurable_id")
            ->pluck("total", "measurable_id");

        // Fetch last-24-hour aggregates
        $recentViews = Metric::query()
            ->betweenDates($since24, now())
            ->where("name", "shortcut:views")
            ->where("measurable_type", Shortcut::class)
            ->selectRaw("measurable_id, SUM(value) as total")
            ->groupBy("measurable_id")
            ->pluck("total", "measurable_id");

        $recentDownloads = Metric::query()
            ->betweenDates($since24, now())
            ->where("name", "shortcut:downloads")
            ->where("measurable_type", Shortcut::class)
            ->selectRaw("measurable_id, SUM(value) as total")
            ->groupBy("measurable_id")
            ->pluck("total", "measurable_id");

        // Update in chunks to avoid locking
        Shortcut::chunkById(500, function ($shortcuts) use (
            $allTimeViews,
            $allTimeDownloads,
            $recentViews,
            $recentDownloads,
        ) {
            foreach ($shortcuts as $shortcut) {
                $shortcut->updateQuietly([
                    "views_all_time" => $allTimeViews->get($shortcut->id, 0),
                    "downloads_all_time" => $allTimeDownloads->get(
                        $shortcut->id,
                        0,
                    ),
                    "views_last_24" => $recentViews->get($shortcut->id, 0),
                    "downloads_last_24" => $recentDownloads->get(
                        $shortcut->id,
                        0,
                    ),
                ]);
            }
        });

        Shortcut::chunkById(500, fn($chunk) => $chunk->searchable());

        $this->info("Shortcut metrics updated successfully.");
    }
}
