<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([ 'user_id' => '1', 'client_name' => 'client_name1_01', 'client_address' => 'client_address01', 'client_nip' => 'client_nip01', 'created_at' => '2022-06-10 01:18:19']);
        DB::table('clients')->insert([ 'user_id' => '1', 'client_name' => 'client_name1_02', 'client_address' => 'client_address02', 'client_nip' => 'client_nip02', 'created_at' => '2022-06-11 10:17:16']);
        DB::table('clients')->insert([ 'user_id' => '1', 'client_name' => 'client_name1_03', 'client_address' => 'client_address03', 'client_nip' => 'client_nip03', 'created_at' => '2022-04-20 02:11:14']);


        DB::table('clients')->insert([ 'user_id' => '2', 'client_name' => 'client_name2_01', 'client_address' => 'client_address01', 'client_nip' => 'client_nip01', 'created_at' => '2022-06-10 01:18:19']);
        DB::table('clients')->insert([ 'user_id' => '2', 'client_name' => 'client_name2_02', 'client_address' => 'client_address02', 'client_nip' => 'client_nip02', 'created_at' => '2022-06-11 10:17:16']);
        DB::table('clients')->insert([ 'user_id' => '2', 'client_name' => 'client_name2_03', 'client_address' => 'client_address03', 'client_nip' => 'client_nip03', 'created_at' => '2022-04-20 02:11:14']);

        DB::table('clients')->insert([ 'user_id' => '3', 'client_name' => 'client_name3_01', 'client_address' => 'client_address01', 'client_nip' => 'client_nip01', 'created_at' => '2022-06-10 01:18:19']);
        DB::table('clients')->insert([ 'user_id' => '3', 'client_name' => 'client_name3_02', 'client_address' => 'client_address02', 'client_nip' => 'client_nip02', 'created_at' => '2022-06-11 10:17:16']);
        DB::table('clients')->insert([ 'user_id' => '3', 'client_name' => 'client_name3_03', 'client_address' => 'client_address03', 'client_nip' => 'client_nip03', 'created_at' => '2022-04-20 02:11:14']);


    }
}
