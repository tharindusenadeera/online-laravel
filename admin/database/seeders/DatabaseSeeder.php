<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;


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

            [
                'name'           => "Lorem Ipsum",
                'email'          => 'example@gmail.com',
                'password'       => Hash::make('Admin@123'),
                'user_level'     => 'admin',
                'username'       => 'admin',
                'remember_token' => 'example_token',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            
        ]);

    }
}
