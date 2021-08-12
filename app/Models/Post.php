<?php

namespace App\Models;

use Illuminate\Support\Facades\File;

class Post
{

    static function all() {
        try {
            $posts = cache()->remember("posts.all", now()->addSecond(30), function () {
                $files = File::allFiles(resource_path("posts"));
                return array_map(fn($post) => $post->getContents(), $files);
            });
        } catch (\Exception $e) {
            $posts = [];
        }
        return $posts;
    }

}
