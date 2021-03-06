<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(rand(30, 50)),
            'content' => $this->faker->text(4000),
            'created_at' => now(),
            'published' => 1,
            'user_id' => User::factory(),
        ];
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withAuthor($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
