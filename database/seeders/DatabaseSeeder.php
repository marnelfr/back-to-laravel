<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
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
        $user = User::factory()->create([
            'name' => 'Marnel Gnacadja',
            'username' => 'marnelfr'
        ]);
        $category = Category::factory()->create([
            'name' => 'Hobbies',
            'slug' => 'hobbies'
        ]);

        Post::factory(2)->create([
            'user_id' => $user->id
        ]);
        Post::factory(5)->create();
        Post::factory(4)->create([
            'category_id' => $category->id
        ]);
    }
}
