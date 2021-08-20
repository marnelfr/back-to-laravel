<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{

    public function store (Post $post): \Illuminate\Http\RedirectResponse
    {
        $attributes = request()->validate([
            'body' => 'required|min:2'
        ]);

        $attributes['user_id'] = auth()->id();
        $post->comments()->create($attributes);

        return back()->with('success', 'Comment add successfully');
    }

}
