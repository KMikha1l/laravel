<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                "id" => 1,
                "user_id" => 1,
                "title" => "First post",
                "content" => "Post content. Bla bla bla...",
                "created_at" => "2018-12-07 15:11:07",
                "updated_at" => "2018-12-07 15:11:07",
            ],
            [
                "id" => 2,
                "user_id" => 1,
                "title" => "Second post",
                "content" => "Second post content. Bla bla bla...",
                "created_at" => "2018-12-07 15:11:07",
                "updated_at" => "2018-12-07 15:11:07",
            ],

        ]);
    }
}
