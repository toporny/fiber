<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blowdatas', function (Blueprint $table) {
            //$table->id();
            $table->integer('blowing_id');
            $table->datetime('datetime');
            $table->double('speed', 8, 2);
            $table->double('force', 8, 2);
            $table->double('pressure', 8, 2);
            $table->double('length', 8, 2);
            $table->integer('trip_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blowdatas');
    }
};
