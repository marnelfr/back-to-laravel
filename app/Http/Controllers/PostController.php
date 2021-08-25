<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function index() {
        return view('posts.index', [
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author'])
            )->simplePaginate(6)->withQueryString()
        ]);
    }

    public function show(Post $post) {
        return view('posts.show', compact('post'));
    }

    public function create () {
        return view('posts.create', [
            'categories' => Category::all()
        ]);
    }

    public function store (PostRequest $request) {
        $attributes = $request->except(['thumbnail']);

        $attributes['user_id'] = auth()->id();
        $attributes['publish_at'] = now();
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnail');

        Post::create($attributes);

        return redirect('/')->with('success', 'Post create successfully');
    }
}
