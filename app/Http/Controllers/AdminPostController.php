<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{

    public function index () {
        return view('admin.posts.index', [
            'posts' => Post::where('user_id', auth()->id())->orderBy('id', 'DESC')->get()
        ]);
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

    public function edit (Post $post) {
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    public function update(PostRequest $request, Post $post) {
        // TODO: start using only section by this side
        $attributes = $request->except('thumbnail');
        if ($request->thumbnail) {
            File::delete($post->thumbnail);
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnail');
        }

        $post->update($attributes);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully');
    }


}
