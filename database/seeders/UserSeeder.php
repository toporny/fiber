<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'rzepr',
            'email' => 'rzepr@termagroup.pl',
            'is_admin' => '0',
            'password' => Hash::make('rzeprrzepr99'),
        ]);

        DB::table('users')->insert([
            'username' => 'klipi',
            'email' => 'klipi@termagroup.pl',
            'is_admin' => '0',
            'password' => Hash::make('klipiklipi99'),
        ]);

        DB::table('users')->insert([
            'username' => 'klija',
            'email' => 'klija@termagroup.pl',
            'password' => Hash::make('klijaklija99'),
        ]);

        DB::table('users')->insert([
            'username' => 'brzda',
            'email' => 'brzda@termagroup.pl',
            'password' => Hash::make('brzdabrzda99'),
        ]);
    }
}
