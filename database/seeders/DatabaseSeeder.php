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
        DB::table('users')->insert([
            'name'     => 'admin',
            'password' => Hash::make('password'),
        ]);
        DB::table('permissions')->insert([[
            'user_id' => 1,
            'route_name' => 'user.index'
        ],
            [
                'user_id' => 1,
                'route_name' => 'user.edit'
            ],
            [
                'user_id' => 1,
                'route_name' => 'user.update'
            ]]);
    }
}
