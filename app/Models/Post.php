<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

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

    static function find($slug) {
        return static::all()->firstWhere('slug', $slug);
    }

    static function all(): Collection {
        try {
            $posts = cache()->remember('posts.all', now()->addSecond(30), function () {
                return collect(File::files(resource_path('posts')))
                    ->map(fn($file) => YamlFrontMatter::parseFile($file))
                    ->map(fn($document) => new Post(
                        $document->title,
                        $document->excerpt,
                        $document->body(),
                        $document->slug
                    ))
                ;
            });
        } catch (\Exception $e) {
            $posts = [];
        }
        return $posts;
    }

}
