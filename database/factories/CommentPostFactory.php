<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'comment_content'=>$this->faker->sentence(70),
        'post_id'=>1,
        'user_id'=>1,
        'parent_comment'=>null,
        ];
    }
}