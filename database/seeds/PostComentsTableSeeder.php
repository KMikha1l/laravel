<?php

use Illuminate\Database\Seeder;

class PostComentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_coments')->insert([
            [
                "id" => 1,
                "user_id" => 1,
                "post_id" => 1,
                "text" => "comment #1",
                "created_at" => "2018-12-07 15:13:25",
                "updated_at" => "2018-12-07 15:13:25",
            ],
            [
                "id" => 2,
                "user_id" => 1,
                "post_id" => 1,
                "text" => "comment #2",
                "created_at" => "2018-12-07 15:13:32",
                "updated_at" => "2018-12-07 15:13:32",
            ],
        ]);
    }
}
