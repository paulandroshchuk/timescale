<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('account_id');
            $table->string('mobile_id');
            $table->string('name');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->index([
                'account_id',
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
