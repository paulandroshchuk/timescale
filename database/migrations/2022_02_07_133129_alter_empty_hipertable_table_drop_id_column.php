<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEmptyHipertableTableDropIdColumn extends Migration
{
    public function up()
    {
        Schema::table('empty_hipertable', function (Blueprint $table) {
            $table->dropColumn([
                'id',
            ]);
        });
    }
}
