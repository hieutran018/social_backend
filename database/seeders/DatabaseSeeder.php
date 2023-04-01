<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(35)->create();
        // \App\Models\Post::factory(10)->create();
        // \App\Models\MediaFilePost::factory(4)->create();
        // \App\Models\CommentPost::factory(15)->create();
    }
}