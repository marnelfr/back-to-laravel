<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeCommentTest extends TestCase
{

    /**
     * @test
     */
    public function a_comment_cab_be_liked () {
        $user = User::factory()->create();
        $this->actingAs($user);
        $comment = Comment::factory()->create();
        $comment->like();
        $this->assertCount(1, $comment->likes);
    }

}
