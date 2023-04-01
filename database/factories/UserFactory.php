<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'avatar'=> 'avatar_default_male.png',
            'cover_image'=>'cover_image_default.jpeg',
            'date_of_birth' => now(),
            'sex'=> rand(1,2) % 2 === 0 ? 1 : 0 ,
            'went_to'=>rand(1,2)  % 2 === 0 ? 'Vĩnh Long' : 'Thành phố Hồ Chí Minh',
            'live_in'=> 'Thành phố Hồ Chí Minh',
            'relationship'=>rand(1,2)  % 2 === 0 ? 1 : 0,
            'address'=>'Thanh Pho Ho Chi Minh',
            'token'=> null,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
            'isAdmin'=> 0
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}