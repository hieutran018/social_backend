<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'post_content'=>$this->faker->sentence(255),
        'user_id'=>1,
        'privacy'=>1,
        'parrent_post'=>null,
        'status'=>1
        ];
    }

}