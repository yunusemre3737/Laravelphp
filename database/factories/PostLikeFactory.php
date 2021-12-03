<?php

namespace Database\Factories;

use App\Models\PostLike;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostLikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostLike::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>rand(1,8),
            'post_id'=>rand(1,10),
            'status' => $this->faker->randomElement(['like' ,'dislike',null]),
        ];
    }
}
