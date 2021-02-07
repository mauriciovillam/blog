<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use WithFaker;

    public function test_home_screen_can_be_rendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_post_component_renders_properly()
    {
        $view = $this->blade(
            '<x-blog-post :title="$title" :content="$description" :date="$published_at" :owner="$user"/>',
            $data = [
                'title' => $this->faker->text,
                'description' => $this->faker->text,
                'published_at' => new \DateTime,
                'user' => User::factory()->create()
            ]
        );

        $view->assertSee($data['title']);
        $view->assertSee($data['description']);
        $view->assertSee($data['published_at']->format('F jS, Y'));
        $view->assertSee($data['user']->name);
    }
}
