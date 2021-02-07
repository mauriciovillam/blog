<?php

namespace Tests\Feature\Commands;

use App\Data\Collections\FeedServicePostCollection;
use App\Services\FeedService;
use App\Data\FeedServicePost;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class ImportPostsFromFeedCommandTest extends TestCase
{
    public function test_it_imports_posts_from_feed_service()
    {
        User::factory()->create([
            'email' => config('post.default_owner_email')
        ]);

        $this->mock(FeedService::class, function ($mock) {
           $mock->shouldReceive('fetch')->andReturn(
               new FeedServicePostCollection([
                   new FeedServicePost([
                       'title' => 'Title',
                       'description' => 'Description',
                       'publication_date' => '2020-01-01 00:00:00'
                   ])
               ])
           );
        });

        $this->artisan('feed:import')->assertExitCode(0);

        $this->assertInstanceOf(Post::class, Post::where('title', 'Title')->first());
    }
}
