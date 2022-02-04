<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('subscriber_id');
            $table->enum('activity_type', ['ACTIVITY_OPT_IN', 'ACTIVITY_OPT_OUT', 'TEXT']);
            $table->json('activity_data')->nullable();
            $table->dateTime('created_at', 4);

            $table->index([
                'account_id',
                'activity_type',
                'created_at',
            ]);

            $table->index([
                'subscriber_id',
                'created_at',
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
