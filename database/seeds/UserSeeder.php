<?php

use Illuminate\Database\Seeder;
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

        // Add users

        DB::table('users')->insert(

            [
                'email' => 'test@webbite.de',
                'username' => 'administrator',
                'password' => Hash::make('webbite123'),
                'short_name' => 'Deadpool',
                'first_name' => 'Struktur',
                'last_name' => 'Administrator',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]

        );

        // Add users to mandants

        DB::table('mandant_users')->insert(

            [
                'mandant_id' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ]

        );

        // Add mandant specific roles to users

        DB::table('mandant_user_roles')->insert(

            [
                'mandant_user_id' => 1,
                'role_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]

        );


    }
}