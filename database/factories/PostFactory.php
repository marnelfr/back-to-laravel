<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $body = '';
        foreach ($this->faker->paragraphs(5) as $paragraph) {
            $body .= "<p>{$paragraph}</p>";
        }
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(3),
            'excerpt' => $this->faker->sentences(4, true),
            'body' => $body,
            'user_id' => User::factory()->create(),
            'category_id' => Category::factory()->create()
        ];
    }
}
