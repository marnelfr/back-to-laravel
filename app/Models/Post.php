<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Post
{

    static function find($slug): string {
        return cache()->remember(
            'posts.' . $slug,
            now()->addSecond(30),
            fn() => file_get_contents(resource_path('posts/' . $slug . '.html'))
        );
    }

    static function all(): array {
        try {
            $posts = cache()->remember('posts.all', now()->addSecond(30), function () {
                $files = File::allFiles(resource_path('posts'));
                return array_map(fn($post) => $post->getContents(), $files);
            });
        } catch (\Exception $e) {
            $posts = [];
        }
        return $posts;
    }

}
