<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'role_id' => 1,
                'status' => 1,
                'password' => bcrypt('pass'),
            ]
        ]);
    }
}
