<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Jobs\SeedUsersJob;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $batchSize = 1000; // Number of records per batch
        $totalRecords = 1000000; // 1 million records
        $jobs = $totalRecords / $batchSize;

        for ($i = 0; $i < $jobs; $i++) {
            \Log::info("Dispatching SeedUsersJob for batch " . ($i + 1));
            SeedUsersJob::dispatch($batchSize);

        }
    }
}
 