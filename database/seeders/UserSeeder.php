<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::raw('CREATE EXTENSION IF NOT EXISTS "pgcrypto"');
        DB::table('users')->insert([
            'name' => 'Gustavo Claure Flores',
            'email' => 'gclaure@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
