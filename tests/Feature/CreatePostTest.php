<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    public function test_create_post_can_be_rendered()
    {
        $this->actingAs(User::factory()->create());
        $this->get('/dashboard/post')->assertStatus(200);
    }

    public function test_create_post_cant_be_rendered_as_guest()
    {
        $this->get('/dashboard/post')->assertStatus(302);
    }
}
