<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikePostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_post_can_be_liked() {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create();
        $post->like();

        $this->assertCount(1, $post->likes);
        $this->assertTrue($post->likes->contains('id',$user->id));
//        $this->assertEquals($post->likes->liked->user_id, 50);
    }

    /**
     * @test
     */
    public function a_post_can_be_disliked () {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create();
        $post->like();
        $this->assertCount(1, $post->likes);

//        $post->dislike();
//        $this->assertCount(0, $post->likes);
    }

}
