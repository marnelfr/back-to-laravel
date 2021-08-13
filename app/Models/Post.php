<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

    public $title;
    public $excerpt;
    public $body;
    public $slug;
    public $date;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->body = $body;
        $this->slug = $slug;
        $this->date = $date;
    }

    static function findOrFail($slug) {
        $post = static::find($slug);

        if (!$post) {
            throw new ModelNotFoundException();
        }

        return $post;
    }

    static function find($slug) {
        return static::all()->firstWhere('slug', $slug);
    }

    static function all(): Collection {
        try {
            $posts = cache()->rememberForever('posts.all', function () {
                return collect(File::files(resource_path('posts')))
                    ->map(fn($file) => YamlFrontMatter::parseFile($file))
                    ->map(fn($document) => new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->body(),
                        $document->slug
                    ))
                    ->sortByDesc('date')
                ;
            });
        } catch (\Exception $e) {
            $posts = [];
        }
        return $posts;
    }

}
