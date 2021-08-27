<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
    <a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Eloquent
Eloquent is the ORM used by laravel. Here, we're going to take a look at each
type of relationship provided by Eloquent.

### Debug our queries
We can ``dump`` every sql query executed behind the sine by Eloquent: 
````injectablephp
DB::listen(function ($sql) {
    var_dump($sql->sql, $sql->bindings);
});
````

Otherwise, we can enable the query log by doing:
````injectablephp
DB::enableQueryLog();
````
Since then, we can show queries executed by Eloquent doing:
````injectablephp
DB::getQueryLog();
````

### One to One
It's not always because the user has one that we should have it in the user table.
Let's think about the case we want to save information about the user GitHub
profile. It's ok, there only one think to add to our user table.\
But from the moment we no longer have to deal with only the GitHub profile but
also twitter, stackoverflow, and other profiles, we should consider setting up
a profile table to hold this information.\
That's where the **One to One** relationship come in.\
To add a **One to One** relationship between the ``users`` and the ``profile``
table, we've got to:
- add ``foreignId`` to our migration:
  - ``foreignId('user_id')`` in the profiles table
  - ``foreignId('profile_id')`` in the users table.
- add ``profile()`` method to the User model and ``user()`` method to the Profile model
````injectablephp
    // User model
    public function profile() {
        return $this->hasnOne(Profile::class);
    }

    // Profile model
    public function user() {
        return $this->belongsTo(User::class);
    }
````
- Access the profile/user information from the $user/$profile
``$profile->user->username``/``$user->profile->github_url``
- Add profile\user to the ``$with`` attributes in the User/Profile model if
we're going to need it often.


### One to Many
[A one-to-many relationship](https://developer.android.com/training/data-storage/room/relationships#one-to-one) 
between two entities is a relationship where each instance of the parent 
entity corresponds to zero or more instances of the child entity, but each 
instance of the child entity can only correspond to exactly one instance of 
the parent entity.\
Let's take a look at the posts wrote by a user on a blog. Well, every user 
can write as many posts as we want. So we can say **user has many posts**
So here, the posts' table will hold the id of his author (user)
``$table->foreignId('user_id')`` and we'll add some methods to their Models:
````injectablephp
// Post model:
public function author() {
    return $this->belongsTo(User::class, 'user_id');
    //we've got to specify the column (here user_id) in the case our function name doesn't match the column name without '_id'
}

// User mode:
public function posts() {
    return $this->hasMany(Post::class);
}
````
Since then, we can access posts wrote by a user using ``$user->posts->first()`` and from
a post, access to its author using ``$post->author->name``


### Many to Many
In case we've got a Many-to-Many relationship between two models, let's say Post
and Tag, here are what to do:
- create our pivot table. Conventionally, it's named by the singular of the two
model names (``post_tag``) but we can name it as we want: ``artisan make:migration create_post_tag_table``
````injectablephp
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
            // $table->boolean('main')->default(false);
            $table->timestamps();
        });
    }
````
- add the ``posts()`` and ``tags()`` methods to the models:
````injectablephp
    // in Post model
    public function tags () {
        return $this->belongsToMany(Tag::class)
            ->withTimestamps() // used only if we're saving timestamps in our pivot table
            ->as('tagger') // used if we don't want to access our pivot table through the 'pivot' attribute
            ->wherePivot('main', true) // will make our relation 'tags' to access only main tags. So may be renamed mainTags
            ->wherePivotIn('priority', [1,2,3]) // same as the previous line    
        ;
    }

    // in Tag model
    public function posts () {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
````
The ``withTimestamps()`` method is used only if we want our pivot table
to have the ``timestamps`` columns.

- ``$post->tags()->attach(1)`` can be used to attach tags to our post. However, ``attach()``
throw a QueryException (in with this such of set up) when we try to attach the same record twice.
- ``$tag->posts()->detach(['1,2'])`` can be used to detach our tags' posts.
- ``$tag->posts->pivot`` to access the pivot table then to timestamp if needed.

Our pivot table may have more attributes. For this purpose, let uncomment the
boolean line in our migration's ``up()`` function. Thus, we'll have to add to 
our ``posts()`` and ``tags()`` methods' code: ``->withPivot('main')``. It will
receive a table if it's more than one column.

- ``$tag->posts()->attach($post, ['main' => true]);`` will then used to attach


### Has Many Through
I kind of relationship I didn't know about before. Here, our main Model 
has many related record in a third table based on its relationship with 
a second table.\
Example: let's imagine our users have a political affiliation. And we're looking
for posts wrote by every one from a specific affiliation. That's it.
- users(id, affiliation_id, name)
- posts(id, title, body, user_id)
- affiliations(id, name)

In our Affiliation Model, we'll have:
````injectablephp
public function posts() {
    return $this->hasManyThrough(Post::class, User::class);
    // Read: A specific affiliation has many posts through the user's table
}
````























