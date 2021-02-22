<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
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

        DB::table('servers')->insert([
            [
              'name' => 'test1',
              'host' => 'test1.com',
              'http_port' => '80',
              'https_port' => '444',
              'owner' => '2'  
            ],
            [
              'name' => 'test2',
              'host' => 'test2.com',
              'http_port' => '80',
              'https_port' => '444',
              'owner' => '3'  
            ],
        ]);


    }
}
