<?php

namespace App\Traits;

use App\Models\User;

trait Likable {

    public function likes() {
        return $this->morphToMany(User::class, 'likable')
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
