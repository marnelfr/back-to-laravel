<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $with = ['author', 'category'];

    public function scopeFilter($query, $filters) {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) => $query
                ->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('body', 'like', '%' . $filters['search'] . '%')
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

}
