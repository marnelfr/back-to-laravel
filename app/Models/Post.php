<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $with = ['author', 'category'];

    protected $guarded = [];

    public function scopeFilter($query, $filters) {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) => $query->where(
                fn($query) => $query
                    ->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('body', 'like', '%' . $filters['search'] . '%')
            )
        );
        $query->when(
            $filters['category'] ?? false,
            fn($query, $categorySlug) => $query
                ->whereHas('category', fn($query) => $query->where('slug', $categorySlug))
        );
        $query->when(
            $filters['author'] ?? false,
            fn($query, $author) => $query
                ->whereHas('author', fn($query) => $query->where('username', $author))
        );
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function tags () {
        return $this->belongsToMany(Tag::class)->withTimestamps()->withPivot('main');
    }

    public function likes() {
        return $this->belongsToMany(User::class)
            ->as('liked')
            ->withTimestamps();
    }

    public function like (?User $user = null) {
        $user ??= auth()->user();
        $this->likes()->attach($user);
    }

    public function dislike (?User $user = null) {
        $user ??= auth()->user();
        $this->likes()->detach($user);
    }

}
