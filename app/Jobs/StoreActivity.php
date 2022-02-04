<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        return \App\Models\Activity::create([
            'account_id' => rand(1, 5_000),
            'subscriber_id' => rand(1, 2_000_000),
            'activity_type' => ['ACTIVITY_OPT_IN', 'ACTIVITY_OPT_OUT', 'TEXT'][rand(0, 2)],
            'activity_data' => '{"type": "Some data here.", "uuid": "4261b720-9568-48d8-81ca-3cda48905ca8", "user_id": 892, "message_id": 205403, "another_one": "7rxn6abhB5V1r8nNTxqV31w68lrb5q0UhFSH2KKk2ul7tWbvO3"}',
        ]);
    }
}
