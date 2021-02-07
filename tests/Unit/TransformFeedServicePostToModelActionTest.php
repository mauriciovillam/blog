<?php

namespace Tests\Unit;

use App\Actions\TransformFeedServicePostToModelAction;
use App\Data\FeedServicePost;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class TransformFeedServicePostToModelActionTest extends TestCase
{
    public function test_it_transforms_dto_to_model()
    {
        $user = User::factory()->create([
            'email' => config('post.default_owner_email')
        ]);

        $feedServicePost = new FeedServicePost([
            'title' => 'My New Title',
            'description' => 'My New Description',
            'publication_date' => '2020-01-01 00:00:00'
        ]);

        $post = app(TransformFeedServicePostToModelAction::class)->execute($feedServicePost);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('My New Title', $post->title);
        $this->assertEquals('My New Description', $post->description);
        $this->assertEquals('2020-01-01 00:00:00', $post->published_at);
        $this->assertTrue($post->user->is($user));
    }
}
