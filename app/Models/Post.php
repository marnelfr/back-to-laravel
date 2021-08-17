<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $with = ['author', 'category'];

    public function scopeFilter($query, $filters) {
        $query->when($filters['search'] ?? false, fn($query, $search) => $query
            ->where('title', 'like', '%' . $filters['search'] . '%')
            ->orWhere('body', 'like', '%' . $filters['search'] . '%')
        );
        $query->when($filters['category'] ?? false, fn($query, $categorySlug) => $query
            ->whereExists(
                fn($query) => $query
                    ->from('categories')
                    ->whereColumn('categories.id', 'posts.category_id')
                    ->where('categories.slug', $categorySlug)
            )
        );
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
