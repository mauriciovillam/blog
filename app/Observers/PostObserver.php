<?php

namespace App\Observers;

use App\Repositories\PostRepository;
use App\Models\Post;

class PostObserver
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Handle the Post "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        $this->postRepository->clearCache();
        $this->postRepository->clearCache($post->user);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param Post $post
     * @return void
     */
    public function updated(Post $post)
    {
        $this->postRepository->clearCache();
        $this->postRepository->clearCache($post->user);
    }
}
