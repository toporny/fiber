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
        // tutaj przy podnoszeniu bazy i zakładaniu tabeli należałoby jeszcze dorobić relacje do users_table->id
        Schema::create('blowings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->datetime('date_time_from_file')->datetime();
            $table->string('client_name_from_file')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_nip')->nullable();

            $table->string('route_name')->nullable();
            $table->string('route_start')->nullable();
            $table->string('route_end')->nullable();
            $table->double('route_gps_cords_x',13,10)->nullable();
            $table->double('route_gps_cords_y',13,10)->nullable();
            $table->string('operator')->nullable();
            $table->string('place_location')->nullable();

            $table->string('pipe_manufacturer')->nullable();
            $table->string('pipe_type')->nullable();
            $table->string('pipe_symbol_color')->nullable();
            $table->double('pipe_outer_diameter',8,2)->nullable();
            $table->double('pipe_thickness',8,2)->nullable();
            $table->string('pipe_notes')->nullable();

            $table->string('cable_manufacturer')->nullable();
            $table->integer('cable_how_many_fibers')->nullable();
            $table->double('cable_diameter',8,2)->nullable();
            $table->string('cable_symbol_color')->nullable();
            $table->integer('cable_marker_start')->nullable();
            $table->integer('cable_marker_end')->nullable();
            $table->string('cable_crash_test')->nullable();

            $table->string('blower_serial_number')->nullable();
            $table->string('blower_lubricant')->nullable();
            $table->string('blower_compressor')->nullable();
            $table->string('blower_compressor_pressure')->nullable();
            $table->string('blower_compressor_efficiency')->nullable();
            $table->double('temperature',8,2)->nullable();

            $table->timestamp('installation_time_start')->nullable();
            $table->timestamp('installation_time_end')->nullable();
            $table->double('installation_time_in_minutes',8,2)->nullable();
            $table->integer('numbers_of_samples_from_file')->nullable();
            $table->double('cable_length',8,2)->nullable();

            $table->boolean('blower_separator')->default(0);
            $table->boolean('blower_radiator')->default(0);
            $table->boolean('draft')->default(0);

            $table->enum('language', ['PL', 'EN', 'DE'])->default('PL');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blowings');
    }
};
