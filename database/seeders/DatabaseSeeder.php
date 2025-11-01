<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create(["name" => "iOS Haven"]);

        $user->socialAccounts()->create([
            "provider_name" => "twitter",
            "provider_id" => "715729557769166848",
            "data" => [
                "id" => "715729557769166848",
                "nickname" => "iOSHavencom",
                "name" => "iOS Haven",
                "avatar" =>
                    "http://pbs.twimg.com/profile_images/1478410862012600320/rsEvqO2f_normal.jpg",
            ],
        ]);

        $this->call([RoutineHubSeeder::class]);
    }
}
