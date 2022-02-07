<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmptyHipertablesTable extends Migration
{
    public function up()
    {
        Schema::create('empty_hipertable', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empty_hipertable');
    }
}
