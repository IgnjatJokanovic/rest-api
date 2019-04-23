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
        // DB::table('users')->insert([
        //     'name' => "Ignjat",
        //     'email' => 'ignjat@gmail.com',
        //     'password' => bcrypt('123456')
        // ]);

        // DB::table('users')->insert([
        //     'name' => "Nikola",
        //     'email' => 'nikola@gmail.com',
        //     'password' => bcrypt('123456')
        // ]);

        DB::table('articles')->insert([
            'title' => "Test",
            'body' => 'TEST',
            'main_image' => 'img/test',
            'alt' => 'TEST',
            'user_id' => 1
        ]);

        DB::table('articles')->insert([
            'title' => "Test1",
            'body' => 'TEST1',
            'main_image' => 'img/test1',
            'alt' => 'TEST1',
            'user_id' => 1
        ]);

        DB::table('articles')->insert([
            'title' => "Test2",
            'body' => 'Test2',
            'main_image' => 'img/test1',
            'alt' => '',
            'user_id' => 1
        ]);
    }
}
