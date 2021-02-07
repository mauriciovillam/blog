<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    protected PostRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = app(PostRepository::class);
    }

    public function test_all_method_returns_all()
    {
        $posts = Post::factory()->count(3)->for(User::factory())->create();
        $all = $this->repository->all();

        foreach ($all as $post) {
            $this->assertTrue($posts->contains($post));
        }
        $this->assertEquals($posts->count(), $all->count());
    }
}
