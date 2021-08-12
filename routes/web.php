<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('posts', [
        'posts' =>  Post::all()
    ]);
});

Route::get('/posts/{post}', function ($slug) {

    $title = cache()->remember("posts.{$slug}", now()->addSecond(10), function () use ($slug) {
        var_dump('expensive operation done');
        sleep(2); //representing an expensive operation
        return str_replace('-', ' ', $slug);
    });

    return view('post', [
        'title' => ucfirst($title)
    ]);
})->where('post', '[A-z_\-]+');

