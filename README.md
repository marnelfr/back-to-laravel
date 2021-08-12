<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

### Adding constraints to our route parameters
We can add constraints to our route parameters using `where`
or `whereAlpha` or other things like that:
````injectablephp

Route::get('/posts/{slug}', function ($slug) {
    $title = str_replace('-', ' ', $slug);
    return view('post', [
        'title' => ucfirst($title)
    ]);
})->where('post', '[A-z_\-]+');
````

### Catching expensive operation
What about expensive operation? Should we run them every time
a user tend to access a particular page that run it? No!
We can catch them for a while:
````injectablephp 
$title = cache()->remember("posts.{$slug}", now()->addSecond(10), function () use ($slug) {
    sleep(2); //representing an expensive operation
    return str_replace('-', ' ', $slug);
});
````
Here, ``title`` will be calculated and then add to the 
cache for 20s. After 20s, it will be recalculated again and
then add to the cache,...

### Getting around directory
Laravel provide functions such as
- ``base_path``: return the path to the root of our project
- ``resource_path``: return the path to the **resource directory**
- ``app_path``: return the path to the app directory

They do receive a sub path to a particular file.













