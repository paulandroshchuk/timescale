<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rush-b {--count=10000}', function () {
    $startAt = now();

    foreach (range(1, $this->option('count')) as $item) {
        \App\Models\Activity::create([
            'account_id' => rand(1, 5_000),
            'subscriber_id' => rand(1, 2_000_000),
            'activity_type' => ['ACTIVITY_OPT_IN', 'ACTIVITY_OPT_OUT', 'TEXT'][rand(0, 2)],
            'activity_data' => '{"type": "Some data here.", "uuid": "4261b720-9568-48d8-81ca-3cda48905ca8", "user_id": 892, "message_id": 205403, "another_one": "7rxn6abhB5V1r8nNTxqV31w68lrb5q0UhFSH2KKk2ul7tWbvO3"}',
        ]);
    }

    $this->info('Diff: '.now()->diffInSeconds($startAt));
});
