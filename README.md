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

## Insights
It may be a good habit to use the [PHP Insights](https://github.com/nunomaduro/phpinsights) 
to check your code before each commit (I hope so):
- Installing: ``composer require nunomaduro/insights --dev``
- Publish the conf file: ``php artisan vendor:publish --provider="NunoMaduro\PhpInsights\Application\Adapters\Laravel\InsightsServiceProvider"``
- Usage: ``artisan insights``


## Learning Laravel

### Installing a laravel app using SAIL
``curl -s https://laravel.build/example-app | bash`` can be used to install 
a laravel app in the **example-app** directory.\
Once installed, ``cd example-app`` can be used to access the app's directory 
and then, using ``./vendor/bin/sail up -d`` we can start our app that will be
accessible on ``localhost``.\
Possible to add ``example-app.test`` to our hosts file in order to access to our
app through that url.


### Adding SAIL to an existing app
- ``composer require laravel/sail --dev``
- ``php artisan sail:install``
- ``./vendor/bin/sail up -d``

We can create an alias to make sail easier to use.


### Adding constraints to our route parameters
We can add constraints to our route parameters using `whereNumber`, `whereAlpha`,... 
or using custom regular expressions with ``where``:
````injectablephp

Route::get('/posts/{slug}', function ($slug) {
    $title = str_replace('-', ' ', $slug);
    return view('post', [
        'title' => ucfirst($title)
    ]);
})->where('slug', '[A-z_\-]+');
````

### Catching expensive operations
What about expensive operations? Should we run them every time
a user tend to access a particular page that need their result? No!
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
content of that page is modified.\
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
provided by laravel ? It helps to manage file system.

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
- @include
- {{ }} to show variables 
- {!! !!} to interpret html and show it

Using components with blade need you to have a **resources/view/components**
directory that will hold your components.\
Refer to your components using the tage ``x-componentFileName``

views/components/layout.blade.php:
````html
<!--before the body-->
<body>
    {{ $content }}
</body>
````
???????????????

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
The ORM here is **Eloquent**\
**artisan** provide a lot of command to manage our database through our
migrations.
In a migration, 
- the **up** function is executed by the command
``php artisan migrate``
- the **down** function is executed by the command 
``php artisan migrate:rollback`` for latest migrations
- the command ``php artisan migrate:fresh`` execute the
**up** functions off all migration after deleting every 
table from the database.

### Active Record Pattern
The active record pattern refers to a model in laravel.
Here, the User model refers to the current active record in the 
database's users table.
- ``User::count()`` returns the number of element in the users tables
- ``User::find(1)`` returns the user with id 1
- ``$users = User::all()`` returns a collection of all record in the users' table
- ``$users->pluck('name')`` returns a collection containing only users
names. This is actually like doing ``$users->map(fn($user) => $user->name)``
- ``$users->first()`` returns the first occurrence in the collection like
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
It's possible to create records using the static ``create()`` method
and to update records using the ``update()`` methode. This may lead to
a **MassAssignmentException** if the **protected** field ``$fillable`` 
doesn't contain at least the required fields of our table or if the **protected**
filed ``guarded`` contains any of those require fields.

Notice that the **create** and **update** methods don't need a call to 
the **save** method.

````injectablephp
$post = App\Models\Post::create(['title' => 'the title', 'excerpt' => 'the excerpt', 'body' => 'the body']);
````
Here, we save our new post in ``$post`` only if we need the variable for
any other purpose. Other ways, we can just forget about it.

### Route model binding
It's possible to bind a model to a route but the injected variable must
have the same name as the route key (??wild code) and it uses 
by default the id to retrieve the corresponding record:
````injectablephp
Route::get('/posts/{post}', function (Post $post) {
    return view('post', ['post' => $post]);
})
````

However, if we want to use another (maybe unique) key than the id
(let's say a **slug**), we can let laravel know it by changing 
the current route by ``/posts/{post:slug}``.

In case we've got a lot of route that use another key than the id, we
can notify it in the model using:
````injectablephp
public function getRouteKeyName() {
    return 'slug';
}
````
From there, all of our **route model binding** should use the **slug**
attribute.

### Eloquent relationship
In a migration, you can add a ``foreignId`` column.\
Then, in the corresponding model, add a method named as the foreign 
key model:
````injectablephp
//In the post's migration:
$table->foreignId('category_id');

//In the post's model:
public function category() {
    // Use the corresponding method accorded to their relationship
    return $this->belongsTo(Category::class);
}
````
Since then, category's information can be loaded from its related post
and it can be accessed by ``$post->category``

Likewise, we can have in the category's model:
````injectablephp
public function posts() {
    return $this->hasMany(Post::class);
}
````
And then, we can access a collection of posts related to a 
category using ``$category->posts``

While setting up our foreign attributes, we can set constrained and some
cascade operations if we want:
````injectablephp
$table->foreignId('post_id')->constrained()->cascadeOnDelete();
$table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
````

### Clockwork
Do you about [ClockWork](https://github.com/itsgoingd/clockwork)?
It's used by laravel to debug things like sql as done by doctrine 
in Symfony.
It needs to be installed in the project and has also got an extension 
that need to be installed on the browser. 
[Learn more about the new release](https://underground.works/blog/clockwork-5.1-released-with-database-queries-highlighting-and-more).

### N+1 Problem
The **N+1 Problem** refers to the fact that to load **N record**, we may
make eloquent do **N+1 queries**. This is actually very bad.\
To fix it, we should always load our models with their foreign key model
information if we need them:
````injectablephp
// We should do:
Post::with('category')->get(); //or fist() to get only the first or take(2) for the first two.
// Instead of only doing:
Post::all();
````
The method ``with()`` can take an array listing every model we want to load
with our model or even a list of arguments of those models.

We can sort by desc our post by calling the ``latest()`` method before
the ``with()`` method.

### Seeder
They are used to populating the database as we refresh it.\
Seeders are located in the **database directory**.\
Using seeders, we can use the ``create()`` method even if the **fillable/guarded**
property is not fill in the model.
Then, while refreshing our database base, we can directly 
load our data using: ``artisan migrate:fresh --seed``

### Factories
Using seeds may make us faster but using factories with seeds can
boost your development. It uses ``Faker`` to generate fake data used
to populate our tables.\
They are located in the **database directory** and to use them, we need 
to fill the ``definition()`` method.\
Now, inside a factory, it's possible to call another factory in order
to create our fake data according to their relationship. But the sub-factory
used here should be created as well.

But from inside our seeds, we can also overwrite some of those relationship
factory in order to make multiple article be created by a unique user
for example.

It better to create our factories at the same time we are creating our
model and seed aannnd controllers using:
``artisan make:model Post -mfsc``

### Eager loading relationships
In case we're not loading records from the model but an existing 
variable of a model, we can't use the ``with()`` method but we've got the ``load()``
method that we can use:
````injectablephp
Route::get('/authors/{author}', function (User $author) {
    return view('posts', [
        'posts' => $author->posts->load(['category', 'author'])
    ]);
});
````

### The $with attributes
Just in case we most of the time need to load our model with some
sub-model, we can overwrite the ``$with`` attribute of our model:
````injectablephp
//in our model class:
protected $with = ['author', 'category'];
````
In this case, we've got the ``without()`` method that we can use in case
we don't want to load our model with all the sub-model listed in the ``$with``
attributes.

### Integrating the template
While using component, you can send variables via props:
````html
<x-post-featured-card :post="$posts->first()"/>
````
Here, we've got the first record from the ``$posts`` collection that
will be sent to the ``post-featured-card.blade.php`` component.
Thus, inside the component, we will refer to it:
````injectablephp
@props(['post', 'type' => 'text'])
````
The ``type`` key added is just to let us know that we can set default value
to our props. So if the ``type`` attribute is missed, its value will be **text**.


We can also send attributes, and they are accessible via the ``$attributes``
variable and can even be merged with some default values inside the 
components like this:
````injectablephp
<div {{ $attributes->merge(['class' => 'transition-colors duration-300']) }}></div>
````
Instead of calling the ``merge()`` method, we can directly use the
``$attributes`` variable as a function.\
We can even have ``<div {{ $attributes }}></div>``. In this case, any other attribute
can be set to our component while using it.

If we've already used the first record, it can be skipped:
````injectablephp
@foreach($posts->skip(1) as $post)
    # code...
    <h1>{{ $post->title }}</h1>
    <p>
        Published <time>{{ $post->created_at->diffForHumans() }}</time>
    </p>
@endforeach
````
- The ``diffForHumans()`` method can be used to make date more readable. 
Instead, we can also use ``format('F j, Y, g:i a')``
- While comparing two records, we can use the ``is()`` method:
````injectablephp
$currentCategory->is($category) ? 'They have the same ID' : 'They are different records';
````
- ``$request()->is('/particular/path')`` is used to check if we are on the 
provided path.
- ``$request()->routeIs('routeName')`` same as the previous but here, we're
using the route name.
- ``Post::firstWhere('column', 'value')`` better than 
`Post::where('col', 'val')->first()``



### Alpinejs
[Alpine.js](https://github.com/alpinejs/alpine/tree/v2.8.2) 
offers you the reactive and declarative nature of big frameworks 
like Vue or React at a much lower cost. Why not take a look at it?


### Query scope
It's possible to add method like ``first()``, ``where()`` usable to our models:
````injectablephp
// Inside our Post model:
public function scopeFilter($query, $filters) {
    if ($filters['search'] ?? false) {
        $query->where('title', 'like', '%' . $filters['search'] . '%');
    }
}

// Inside our controller:
public function index() {
    return view('posts', [
        'posts' => Post::latest()->filter(request['search'])->get()
    ]);
}
````
Adding the ``scopeFilter()`` method to our model allow us to use the
``filter()`` method while loading our records.\
Likewise, the query builder offers us the ``when()`` method
that we can use to simplify our scope body. Using it, our scope filter
will become:
````injectablephp
public function scopeFilter($query, $filters) {
    $query->when($filters['search'] ?? false, fn($query, $search) => $query
        ->where('title', 'like', '%' . $search . '%')
    );
}
````

### whereExists
Let's rewrite our ``filter()`` method to get posts about a giving 
category slug using ``whereExists()``:
````injectablephp
public function scopeFilter($query, $filters) {
    // previous filter's code...
    $query->when($filters['category'] ?? false, fn($query, $categorySlug) => $query
        ->whereExists(
            fn($query) => $query
                ->from('categories')
                ->whereColumn('categories.id', 'posts.category_id')
                ->where('categories.slug', $categorySlug)
        )
    );
}
````

### whereHas
We've got another way used to write the previous code using ``whereHas()``:
````injectablephp
public function scopeFilter($query, $filters) {
    // previous filter's code...
    $query->when($filters['category'] ?? false, fn($query, $categorySlug) => $query
        ->whereHas(
            'category', fn($query) => $query->where('slug', $categorySlug)
        )
    );
}
````

### Components
It's possible to use component with they own helpers (stole from meteor.js).
We can create a new one using ``artisan make:component Guest/CategoryComponent``
for example. 
Henceforth, 
- the component view can be found in ``\resources\components\guest``
- the component helper in ``\app\View\Components\Guest``. We can then
from here, send our variable we only need in the component.

We can avoid the ``Guest/`` in our previous command if we dont 
want to put our component in a subdirectory.
we can have the component ``\resources\views\components\guest\card.blade.php``
that will use with the tag ``<x-guest.card />``


### OR condition's issue
Because of some issues that brings the **OR Condition**, it's better
to always group condition where it appear:
````injectablephp
$query->where(
    fn($query) => $query
        ->where('title', 'like', '%' . $filters['search'] . '%')
        ->orWhere('body', 'like', '%' . $filters['search'] . '%')
)
````


### Combining route query
It's possible to combine our query using the ``http_build_query()`` method.
````html
<a href="/?category={{ $category->slug }}&{{ http_build_query(request()->except('category')) }}">
    {{ $category->name }}
</a>
````

### Pagination
We've got the method ``paginate($totalPerPage = 15)`` that can be used
instead of ``get()`` for example.
````injectablephp
$posts = Post::latest()->paginate(6); // or simplePaginate(6);
````
Since then, we can display the pagination's links in our view using 
````injectablephp
{{ $posts->links() }}
````

By default, Laravel uses the tailwind css famework. But we can change 
this in the ``\app\Providers\AppServiceProvider::boot()`` method.
The supported css frameworks are:
- bootstrap 4
- bootstrap 3
- tailwind
- semantic-ui

````injectablephp
public function boot()
{
    Illuminate\Pagination\Paginator::useBootstrap();
}
````

We can even customize the template used by laravel to display
our pages' links. To do so, let's publish them first using:
``artisan vendor:publish``.\
Then we've got to choose the **Tag: laravel-pagination**

We've also got the ``withQueryString()`` method that can be used
to consider our query while changing a page.


### Forms & Registration
While setting up our forms, we shouldn't forget to include 
inside the form tag, the ``@csrf`` input in order to preserve us
against CSRF Attack.\
In server side, we should also validate our inputs values.
To do so, laravel provides the **Vadalidator** that can be used.
Available rules can be found [here](https://laravel.com/docs/8.x/validation#available-validation-rules).
````injectablephp
$attributes = request()->validate([
    'username' => 'required|min:3|max:255|unique:users,username',
    'password' => 'required|min:3',
    'slug' => ['required', Rule::unique('posts', 'slug')],
    'email' => 'required|email|unique:App\Models\User'
]);
````

If we are doing an update, we should consider ignoring our current record:
``Rule::unique('posts', 'slug')->ignore($post->slug)`` (we can just pass ``$post`` to the 
``ignore`` method) and specify the ``@method('PATCH')`` in order to let 
laravel know we're not doing a **POST** request but a **PATCH** one.

To add a delete form, we should do something like:
````html
<form method="POST" action="/admin/posts/{{ $post->id }}">
    @csrf
    @method('DELETE')
    <button class="text-xs text-gray-400">Delete</button>
</form>
````

### Password
Laravel provides the ``bcrypt()`` method that's used to hash user's
password. To check if a user entered the true password, we can use
``Illuminate\Support\Facades\Hash::check('password', 'hashed_password')``
method.

### Mutators & Accessor
````injectablephp
// in app\Models\User.php

// defining a mutator
public function setPasswordAttributes($password) {
    $this->attributes['password'] = bcrypt($password);
}

// defining an accessor
public function getNameAttributes($name) {
    return ucwords($name);
}
````
We only define mutator and accessor we need to customize.


### Handling errors
We can give as default value, the last user's entry
````html
<input name="username" value="{{ old('username') }}" />
````
In this case, when the validation failed, the user is redirect back
to the form with his old values.

We can display errors per input using:
````injectablephp
@error('username')
    <p>{{ $message }}</p>
@enderror
````
Or regroup them this way:
````injectablephp
@if ($errors->any())
    <ul>
        @foreach ($errors as $error)
            <li>{{ $error }}</li>    
        @endforeach
    </ul>
@endif
````

### Flash messages
We can show flash message to users:
````injectablephp
// Using the session
session()->flash('success', 'User added successfully');

// Using the method with()
redirect('/')->with('success', 'User added successfully');
````

In blade, this can be accessed through the session as well:
````injectablephp
@if (session()->has('success'))
    <p>{{ session('success') }}</p>
@endif
````

### Login & Logout
- ``auth()->login($user);`` to login a particular user
- ``auth()->check()`` to check if there is an authenticated user.
- ``auth()->logout()`` to logout the user
- ``auth()->user()`` to get the logged user. Returns null if there is not.
- ``auth()->id()`` stands for ``auth()->user()->id``
- ``auth()->attempt($attributes)`` used to try to log a user in.
While using it, better remember to regenerate the user's session id
with ``session()->regenerate()``. This is a solution against **session
fixation** attack.

We can redirect the user back to the previous page thank to the ``back()``
method:
````injectablephp
return back()->withErrors([
    'email' => 'No way to log you in'
])->withInput();
````
The ``withInput()`` method flash old value entered by the user.\
The ``withErrors()`` method help us to send our errors messages.

We can throw and **validationException** instead of using the``back()`
method:
````injectablephp
throw \Illuminate\Validation\ValidationException::withMessages([
    'email' => 'No way to log you in'
]);
````

In blade:
- ``@guest`` stands for ``@unless(auth()->check())``
- ``@auth`` stands for ``@if(auth()->check())``



### Middleware
Used to add code that will be executed before user can access a certain
route. They are located in the ``app\Http\Middleware`` and are 
referenced in the ``app\Kernel.php``.
Usage:
````injectablephp
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');
````
This means only guest can access to the register route. If the user
is already logged, he'll be redirected to the home page.
That home page is defined in the ``RouteServiceProvider`` on the attribute
``HOME``

We've also got the **auth** middleware that makes a route accessible 
to only logged users.


### Breeze
Laravel provides **Breeze** that help us to set up to full authentication.
It's better to install it at the beginning of the project.\
To do so, just after our first migration, we can install it using the command:\
``composer require laravel/breeze --dev``\
This update our **artisan** command so now, we can install Breeze in our project
using ``artisan breeze:install`` 

It's even possible to set up Breeze with **react** or **vue** js adding
either ``react`` or ``vue`` to the installation command.

**Do not forget to install assets using npm**


### Laravel Jetstream
Not really satisfy by Breeze? Take a look at [Jetstream](https://laravel.com/docs/8.x/starter-kits#laravel-jetstream) 
that's more powerful


### 7 restfull actions
They are: 
- **index**: show all our items
- **show**: show a single item
- **create**: show a page to create an item
- **store**: to persist new item
- **edit**: show a page to edit an item
- **update**: to persist an edition
- **delete/destroy**: to destroy an item 

It may come we'll have to use another named method in our controllers 
but it's better to try staying with those seven as much as possible. 
And in those situations, it's always a signe that we need to create another controller.

### Config
When you add your key to the ``.env`` file, you can also add them to the 
configs files.\
Config files are located in the ``\config`` directory, and we can even add new
config's files.\
Let's take a look at inside a config file, they basically return an associative array:
````injectablephp
return [
    'key1' =>  'value1',
    'key2' => [
        'key21' => 'valueKey21'
    ]   
];
````

Our values can be accessed through ``config('configFileName.key2.key21')``


### The container
So we're able to inject some classes we want to use in our Controllers
and others classes as well. That's because they are bound in the 
container.
So when we inject a variable into our methods, laravel start looking at
the container. If there is not any reference to our injected variable,
the framework then go to take a look at the class and see if it can instantiate
it. If its constructor has some injected variable also, it tries recursively
to instantiate them. But if it comes across a parameter it can't provide 
a value to, it throws a **BindingResolutionException** because it can't then
instantiate the injected value.

So now, to bind a service to the container, we use the ``register()`` method of 
the ``AppServiceProvider``:
````injectablephp
public function register()
{
    app()->bind(Newsletter::class, function() {
        $client = (new ApiClient())->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => config('services.mailchimp.server')
        ]);
        return (new MailChimpNewsletter($client));
    });
}
````
Here, we're binding the ``Newsletter interface`` by instantiating the 
``MailChimpNewsletter class``. So the only place we're referencing to
our MailChimpNewsletter will be in our ``AppServiceProvide``.
In other places in our application, we'll only inject our ``Newsletter interface``
and we're ready to go. 

We can retrieve information from the container using ``app()->get('key')``
or the ``resolve('key')`` function (instead of making an injection maybe).

Sometimes, it may need to make a ``composer dump-autoload`` if you newly
bound class is not correctly working.

Why not take a look at [MailChimp](https://mailchimp.com/developer/marketing/api/list-member-goal/)?

### Admin section
To check if a particular user can access to a particular route, we can use
middleware.
``artisan make:middleware MiddleWareName`` to add a new one.\
Now inside our middlewares, we can ``redirect($path)`` to another path,
``abort($errorCode)`` a specific error (like 403 for forbidden), ...
````injectablephp
public function handle(Request $request, Closure $next) {
    if(auth()->guest()) abort(\Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    return $next($request);
}
````
Since most of the time, we've got more than one middleware per route, 
``$next($request)`` is for kinda saying **Ok, I'm done. If it's only up to me,
he can access the route**. Then the **next** middleware will start its job.
The user only access to the route only it every middleware concerned by the route 
is ok to let him go.

Once we create our middleware, it should be added to the ``\app\Http\Kernel.php`` file.


### Upload files
Add ``enctype="multipart/form-data"`` to the form to make it able to send file.\
``request()->file('fileInputName')`` is used to access to the file uploaded.\
``$path = request()->file('fileInputName')->store($path)`` used save the file using
one of the **fileSystemDrive**. Better use the ``public`` driver that can be 
chosen in the ``\config\filessystems.php`` file.\
It returns the ``$path`` of the file that can be saved on the related record.


### Some tricks
````html
<span>{{ $slot ?? old($name) }}</span>
````
Here, we are showing the value of ``old($name)`` if there is not ``$slot``
provided.

````html
<x-dropdown href="/posts/1" :active="request()->is('/posts/1')">Dashboard</x-dropdown>
````
While using components, ``href`` is a simple attribute while ``:href`` can
be used to provide php expression that will be interpreted.


````injectablephp
protected function validatePost(?Post $post = null): array {
    $post ??= new Post();
    return request()->validate([
        'title' => 'required',
        'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
        'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
        'category_id' => ['required', Rule::exists('categories', 'id')],
    ]);
}
````
It may be usable to add an ``validatePost()`` method to our controller in 
order to not repeat ourselves. Here, using PHP8, we're considering the case
we could use our ``validatePost`` method for both creation and updating post.

````injectablephp
$user = User::inRandomOrder()->first();
````
Helpful to get a random record from a table.

### Custom request
Instead of using the ```validatePost()``` method, we can create a custom request
using ``artisan make:request PostRequest``.\
The validation rules are then set in the ``rules`` method.\
Here, while doing a ``PATCH`` request, we can access the current post through
the name of the injected variable:
````injectablephp
// \routes\web.php
Route::patch('admin/posts/{post:slug}', [PostController::class, 'update']);

// in the PostController
// $post contains the current post because its name match the route key 'post'
public function update(PostRequest $request, Post $post) {
    // code for the $post edition...
}

// in the PostRequest
public function rules()
{
    // here $this->post contains the current post because the injected variable contains the current post.
}
````


### Adding customized validation rules
Inside your custom request, you can define custom validation rules.\
This need to define the controller of the request class and inject 
the ``Illuminate\Validation\Factory`` class. Here is an example:
````injectablephp
    public function __construct(
        array $query = [], array $request = [], array $attributes = [],
        array $cookies = [], array $files = [], array $server = [],
        $content = null, Factory $factory = null
    ){

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $factory->extend(
            'dev_mail',
            function ($attributes, $value, $parameters) {
                return !!strpos($value, '@dev.com');

            },
            __('auth.dev.mail')
        );

    }
````

The rules can then be used with the name **dev_mail** and will throw an error
with the **auth.dev.mail** message if a mail not from **dev.com** is provided.


### Gates
In the ``boot`` method of our ``AppServiceProvider``, we can add a **Gates**
directive:
````injectablephp
Gate::define('admin', function (User $user) {
    return $user->role === 'Admin';
});
````
Since that's done, we can then check if our logged user is allowed by the 
Gates using
- ``Gate::allows('admin')`` => execute the closure used to defined our Gate
- ``request()->user()->can('admin')`` => stand for ``Gate::allows('admin')``
- ``request()->user()->cannot('admin')`` => stand for ``! Gate::allows('admin')``
- ``$this->authorize('admin')`` => execute the closure and abort an ``403`` error
if it returns false.

**In our template**
````injectablephp
@if (auth()->user()->can('admin'))
    /*showing thing or not*/
@endif
````
Or use the ``@can`` directive that do the same job:
````injectablephp
@can('admin')
    /*showing thing or not*/
@endcan
````

It's possible to use a Gate directive as middleware thanks to the ``can`` middleware:
````injectablephp

Route::post('admin/posts', [PostController::class, 'store'])->middleware('can:admin');
````


### Custom Blade directive
We can even create a custom directive in the ``boot()`` method of our 
``AppServiceProvider`` doing:
````injectablephp
Blade::if('admin', function () {
    return request()->user()?->can('admin');
});
````
Notice the ``?`` used in PHP8 who is the **null safe operator**. This is 
important just in case there is not a singing user: kinda cheking if there 
is a logged user before doing our comparison.

Since then, can do something like this in our template:
````injectablephp
@admin()
    /*showing thing or not*/
@admin
````

We can regroup route and apply to them a same middleware:
````injectablephp
Route::middleware('can:admin')->group(function () {
    Route::get('admin/posts', [AdminPostController::class, 'index']);
    Route::get('admin/posts/1', [AdminPostController::class, 'show']);
});
````

``artisan route:list`` shows all route in our application with their applied
middleware and even their name.


### Using resource directive
````injectablephp
Route::middleware('can:admin')->group(function () {
    Route::resource('admin/posts', AdminPostController::class)->except('show');
});
````
Using the resource directive, we can creat routes for the seven 
action for a resource for a controller.\
Using the ``except()`` method, we can except those we don't need.


### Using named routes
Since we can name our route, we can also reference to them using their
name in our views using the ```route()``` method.
````angular2html
<a href="{{ route('posts.show', ['post_id' => 5]) }}"></a>
<a href="{{ route('posts.show', [5]) }}"></a>
````


### Using Queue
If in our application, we send some notification, it may make our application 
because slow. This is where queue come in. Using **queue**, we can keep our 
application very fast every sending a lot of notification in the middle time.
To use it, 
- our notification class must implement the **ShouldQueue** interface;
- we should set up redis (for example) to manage our queue;
- the value of our env variable **QUEUE_CONNECTION** should be **redis**.

Once done, our notification wont be sent automatically anymore.
To make them be sent, we should henceforth execute the cmd 
``sail artisan queue:work``




### Eloquent relationships
Let's get focus on [Eloquent](Eloquent.md)







