<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use \Spatie\YamlFrontMatter\YamlFrontMatter;

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
    $files = \Illuminate\Support\Facades\File::files(resource_path('posts'));
    $documents = array_map(fn($file) => YamlFrontMatter::parseFile($file), $files);
    $posts = array_map(fn($document) => new Post(
        $document->title,
        $document->excerpt,
        $document->body(),
        $document->slug
    ), $documents);
    return view('posts', [
        'posts' =>  $posts
    ]);
});


Route::get('/posts/{post}', function ($slug) {
    return view('post', [
        'post' => Post::find($slug)
    ]);
})->where('post', '[A-z_\-]+');

Route::get("/welcome", fn() => view('welcome'));
