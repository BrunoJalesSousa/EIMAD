<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      public function up()
    {
      Schema::table('video_streams', function (Blueprint $table) {
        $table->integer('order');
        $table->dropColumn('image');
        $table->dropColumn('command');
      });
    }

      public function down()
    {
      Schema::table('video_streams', function (Blueprint $table) {
        $table->dropColumn('order');
        $table->string('image');
        $table->string('commmand');
      });
    }
};
