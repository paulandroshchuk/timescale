<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class ActivitySeeder extends TimescaleSeeder
{
    protected int $rowsToInsert = 50_000_000;

    protected int $uniqueRows = 500_000;

    protected int $workers = 50;

    protected function getTable(): string
    {
        return (new Activity)->getTable();
    }

    protected function dropTableIndexes(Blueprint $table): void
    {
        $table->dropIndex([
            'account_id',
            'activity_type',
            'created_at',
        ]);

        $table->dropIndex([
            'subscriber_id',
            'created_at',
        ]);
    }

    protected function addTableIndexes(Blueprint $table): void
    {
        $table->index([
            'account_id',
            'activity_type',
            'created_at',
        ]);

        $table->index([
            'subscriber_id',
            'created_at',
        ]);
    }

    protected function buildRow(): array
    {
        return [
            'account_id' => rand(1, 1_000),
            'subscriber_id' => rand(1, 5_000_000),
            'activity_type' => $this->getActivityType(),
            'activity_data' => $this->getActivityData(),
            'created_at' => now()->subDays(rand(1, 365 * 10))->setMinute(rand(0, 60))->setHour(rand(0, 24))->setMicroseconds(rand(111111, 999999))->format('Y-m-d H:i:s.u'),
        ];
    }

    protected function getActivityType(): string
    {
        return [
            'ACTIVITY_OPT_IN', 'ACTIVITY_OPT_OUT', 'TEXT'][rand(0, 2)];
    }

    protected function getActivityData(): string
    {
        return json_encode(
            [
                'uuid' => Str::uuid(),
                'type' => 'Some data here.',
                'message_id' => rand(1, 1_000_000),
                'user_id' => rand(1, 10_000),
                'another_one' => Str::random(50),
            ]
        );
    }
}
