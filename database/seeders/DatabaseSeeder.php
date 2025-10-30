<?php

namespace Database\Seeders;

use App\Models\Shortcut;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        str(config("app.app_admins"))
            ->explode(",")
            ->each(function ($email) {
                User::factory()->create([
                    "name" => "System",
                    "email" => $email,
                ]);
            });

        if (config("app.env") !== "production") {
            User::factory(10)->create();
            for ($i = 2; $i < 8; $i++) {
                DB::table("authorables")->insert([
                    "user_id" => $i,
                    "model_id" => 1,
                    "model_type" => Shortcut::class,
                ]);
            }
        }

        $this->call([RoutineHubSeeder::class]);
    }
}
