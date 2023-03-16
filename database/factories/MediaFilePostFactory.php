<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFilePostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'media_file_name'=>'11',
        'media_type'=>'jpeg',
        'post_id'=>'1',
        'user_id'=>'1',
        'status'=>'1'
        ];
    }
}