<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscribersTableSeeder extends Seeder
{
    public function run()
    {
        Subscriber::factory()
            ->count(100_000)
            ->create();
    }
}
