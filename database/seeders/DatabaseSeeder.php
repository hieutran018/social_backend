<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(29)->create();
        // \App\Models\Post::factory(10)->create();
        // \App\Models\MediaFilePost::factory(4)->create();
        // \App\Models\CommentPost::factory(15)->create();

        //run sql file

        $path = database_path('ckc_social.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
