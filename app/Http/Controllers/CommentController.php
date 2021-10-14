<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function create(PostRequest $request)
    {
        return view('admin.posts.edit');
    }

    public function FunctionName()
    {
        $attributes = request()->except([
            'noe' => 'nle'
        ]);
        $a = request()->only(['ne' =>
        'okd']);
        $at = validator()->validate([
            'sdk' => 'required|min:254|max:255|unique:users,id,15,1'
        ]);
    }

    public function index(Request $request)
    {
        $user = User::create();
        $comment = Comment::create();
    }
}
