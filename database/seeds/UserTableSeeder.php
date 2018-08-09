<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        	['name' => 'admin', 'email' => 'thienth32@gmail.com', 'password' => Hash::make('secret')],
        	['name' => 'member', 'email' => 'member@gmail.com', 'password' => Hash::make('secret')],
        ];

        DB::table('users')->insert($users);
    }
}
