<?php

use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::get('newsletter', function () {
//    request()->validate(['email' => 'required|email']);
    $client = new \MailchimpMarketing\ApiClient();

    $client->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => config('services.mailchimp.server')
    ]);


//    $response = $client->lists->getAllLists();

//    $response = $client->lists->getList('707f652308');
    $response = $client->lists->getListMembersInfo('707f652308');
    ddd($response);

    try {
        $response = $client->lists->addListMember("707f652308", [
            "email_address" => request('email'),
            "status" => "subscribed",
        ]);
    } catch (Exception $e) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Please provide a meaningful email'
        ]);
    }
    return back()->with('success', "You've been added to our newsletter successfully");

//    $response = $client->lists->updateListMember("707f652308", md5('gmlginolias@gmail.com'), [
//        'status' =>  'unsubscribed'
//    ]);

});

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

Route::post('posts/{post:slug}/comment', [PostCommentsController::class, 'store'])->middleware('auth');

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');
