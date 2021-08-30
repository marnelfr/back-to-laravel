<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
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
            'username' => 'marnel',
            'email' => 'nel@net.fr',
            'password' => 'secret'
        ]);
        $category = Category::factory()->create([
            'name' => 'Hobbies',
            'slug' => 'hobbies'
        ]);

        Post::factory(5)->create([
            'user_id' => $user->id
        ]);
        Post::factory(5)->create();
        Post::factory(18)->create([
            'category_id' => $category->id
        ]);

        Collection::factory(7)->create();

        Video::factory(7)->create();

        for ($i = 0; $i<6; $i++) {
            Video::factory(2)->create([
                'watchable_type' => Collection::class,
                'watchable_id' => Collection::inRandomOrder()->first()
            ]);
        }

    }
}
