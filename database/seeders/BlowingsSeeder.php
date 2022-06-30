<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class BlowingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'user_id' => 1,
            'date_time_from_file' => '2022-06-01 17:13:53',
            'client_name_from_file' => 'Deutsche Telecom',
            'client_name' => 'client_name2',
            'client_address' => 'client_address2',
            'client_nip' => 'client_nip2',
            'route_name' => 'route_name2',
            'route_start' => 'route_start2',
            'route_end' => 'route_end2',
            'route_gps_cords_x' => '54.37156891389063',
            'route_gps_cords_y' => '18.44291915804791',
            'operator' => 'operator2',
            'place_location' => 'city2',
            'pipe_manufacturer' => 'pipe_manufacturer2',
            'pipe_type' => 'pipe_type2',
            'pipe_symbol_color' => 'pipe_symbol_color2',
            'pipe_outer_diameter' => 1.1,
            'pipe_thickness' => 2.2,
            'pipe_notes' => 'pipe notes2',
            'cable_manufacturer' => 'cable_manufacturer2',
            'cable_how_many_fibers' => 12,
            'cable_diameter' => 1.1,
            'cable_symbol_color' => 'cable_symbol_color',
            'cable_crash_test' => 'cable_crash_test2',
            'cable_marker_start' => 100,
            'cable_marker_end' => 200,
            'blower_serial_number' => 'FIBER-123-324-4566',
            'blower_lubricant' => 'blower_lubricant2',
            'blower_compressor' => 'blower_compressor2',
            'blower_compressor_pressure' => 'blower_compressor_pressure2',
            'blower_compressor_efficiency' => 'blower_compressor_efficiency2',
            'temperature' => 21.3,
            'blower_separator' => 1, // bool
            'blower_radiator' => 0,  // bool 
            'draft' => 0,  // draft 
            'language' => 'PL',
            'created_at' => '2022-06-05 14:11:11',
            'updated_at' => '2022-06-05 14:11:11',
            'installation_time_start' => '2022-06-01 17:13:53',
            'installation_time_end' => '2022-06-01 17:13:53',
            'installation_time_end' => '2022-06-01 17:13:53',
            'installation_time_in_minutes' => 2.3,
            'numbers_of_samples_from_file' => '49',
            'cable_length' => '70.5',

        ];
        
        $data['user_id'] = 1;
        for ($i=1; $i<4; $i++) DB::table('blowings')->insert($data);

        $data['user_id'] = 2;
        for ($i=1; $i<4; $i++) DB::table('blowings')->insert($data);

        $data['user_id'] = 3;
        for ($i=1; $i<4; $i++) DB::table('blowings')->insert($data);

        $data['user_id'] = 4;
        for ($i=1; $i<4; $i++) DB::table('blowings')->insert($data);

    }
}
