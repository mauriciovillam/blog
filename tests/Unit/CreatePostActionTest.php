<?php

namespace Tests\Unit;

use App\Actions\CreatePostAction;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class CreatePostActionTest extends TestCase
{
    public function test_action_should_create_post()
    {
        app(CreatePostAction::class)->execute(
            ['title' => 'My New Title', 'description' => 'My New Description'],
            $user = User::factory()->create()
        );

        $post = Post::where('title', 'My New Title')
            ->where('description', 'My New Description')
            ->where('user_id', $user->id)
            ->first();

        $this->assertInstanceOf(Post::class, $post);
    }
}
