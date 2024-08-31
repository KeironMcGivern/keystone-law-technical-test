<?php

namespace Database\Seeders;

use App\Models\PinnedLink;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        PinnedLink::factory()->count(50)->create();
    }
}
