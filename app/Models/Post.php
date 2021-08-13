<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Post
{

    public $title;
    public $excerpt;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->body = $body;
        $this->slug = $slug;
    }

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
