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
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'type' => 'admin'
            ],
            [
                'username' => 'test1',
                'email' => 'test1@test.com',
                'password' => Hash::make('12345678'),
                'type' => 'partner'
            ],
            [
                'username' => 'test2',
                'email' => 'test2@test.com',
                'password' => Hash::make('12345678'),
                'type' => 'partner'
            ],
        ]);
    }
}
