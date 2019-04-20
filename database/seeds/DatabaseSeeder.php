<?php

use Illuminate\Database\Seeder;

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
            'name' => "Ignjat",
            'email' => 'ignjat@gmail.com',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'name' => "Nikola",
            'email' => 'nikola@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
