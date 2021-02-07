<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class StorePostTest extends TestCase
{
    public function test_it_stores_post()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->followingRedirects()->post('/dashboard/post', [
            'title' => 'My New Title',
            'description' => 'My New Description'
        ]);

        $response->assertStatus(200)->assertSee('The post has been created successfully');
        $this->assertInstanceOf(Post::class, Post::where('title', 'My New Title')->first());
    }

    public function test_it_doesnt_store_post_as_guest()
    {
        $this->get('/dashboard/post')->assertStatus(302);
    }
}
