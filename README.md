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
$title = cache()->remember("posts.{$slug}", now()->addSecond(20), function () use ($slug) {
    sleep(2); //representing an expensive operation
    return str_replace('-', ' ', $slug);
});
````
Here, ``title`` will be calculated and then add to the 
cache for 20s. After 20s, it will be recalculated again and
then add to the cache,...

#### Great idea
Here a great idea will be to cache forever the content of 
a particular page and then forget it from the cache when the
content of that page is modify.\
For example, it could be great to cache the post list and 
forget it as a new post is created.
````injectablephp
cache()->forget('posts.list');
cache()->rememberForever('posts.list', callback());
````

### Getting around directory
Laravel provides functions such as
- ``base_path``: return the path to the root of our project
- ``resource_path``: return the path to the **resource directory**
- ``app_path``: return the path to the app directory

They do receive a sub path to a particular file.


### YamlFrontMatter
Do you know about the [YamlFrontMatter](https://github.com/spatie/yaml-front-matter) ?\
Go and take a look at it :)


### FileSystem management
Do you know about the ``Illuminate\Support\Facades\File`` 
provide by laravel ? It helps to manage file system.


### Blade
- @foreach
  - inside here, we've got the ``$loop`` variable that give use a lot
of information about the iteration such as
    - iteration: index1
    - index: index0
    - remaining: count - index1
    - count: size
    - first: ``true`` if it's the first iteration
    - last: ``true`` if it's the last iteration
    - odd/even
    - depth: the nesting level
    - parent: the parent iteration loop in a nested level
- @if
- @unless
- @dd
- @yield -> @extends
- {{ }} to show variables 
- {!! !!} to show html

Using components with blade need you to have a **resources/view/components**
directory that will hold your components.\
Refer to your components using the tage ``x-componentName``

views/components/layout.blade.php:
````html
<body>
    {{ $content }}
</body>
````
↓↓↓↓↓

views/posts.blade.php:
````html
<x-layout>
    <x-slot name="content">
        Hello world
    </x-slot>
</x-layout>
````

Components do have a default slot. To use it, simply
replace ``$content`` by ``$slot`` then the **posts.blade.php** 
content will become:
````html
<x-layout>
    Hello world
</x-layout>
````

### Database
The database ORM here is **Eloquent**\
**artisan** provide a lot of command to manage the database through our
migrations.
In a migration, 
- the **up** function is executed by the command
``php artisan migrate``
- the **down** function is executed by the command 
``php artisan migrate:rollback`` for latest migrations
- the command ``php artisan migrate:fresh`` execute the
**up** functions off all migration after deleting every 
table in the database.

### Active Record Pattern
The active record pattern refers to a model in laravel.
Here, the User model refers to the current active record in the users table 
in the database.
- ``User::count()`` returns the number of element in the users tables
- ``User::find(1)`` returns the user with id 1
- ``$users = User::all()`` returns a collection of all record in the users table
let's say in the ``$users`` variable
- ``$users->pluck('name')`` returns a collection containing only users
names. This is actually like doing ``$users->map(fn($user) => $user->name)``
- ``$users->first()`` returns the first user in the collection like
``$users[0]``
- ``$user->save()`` to save a new user into the database. Returns ``true`` if succeed
- ``$user->fresh()`` rollback to information currently in the database

### Dealing with model
- ``php artisan make:migration create_posts_table`` used to create a new
migration\
Once the migration is created, the **up** method should be customized according 
to our need
- ``php artisan migrate`` to modify the database according to new migrations
- ``php artisan make:model Post`` to add a model for the table we've just created

### MassAssignment
It's possible to create record using the static ``create()`` methode
and to update record using ``update()`` methode. This may lead to
a **MassAssignmentException** if the **protected** field ``fillable`` 
doesn't contain at least the required field of our table or if the **protected**
filed ``guarded`` contains any of those require fields.

Notice that the **create** and **update** methode don't need a call to 
the **save** method.

````injectablephp
$post = App\Models\Post::create(['title' => 'the title', 'excerpt' => 'the excerpt', 'body' => 'the body']);
````
Here, we save our new post in ``$post`` only if we need the variable for
any other purpose. Other ways, we can just forget about it.

























