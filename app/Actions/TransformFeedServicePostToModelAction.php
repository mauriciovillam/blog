<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;
use App\Data\FeedServicePost;
use App\Models\Post;
use App\Models\User;

class TransformFeedServicePostToModelAction
{
    /**
     * Transform the FeedServicePost DTO into a Post model.
     *
     * @param FeedServicePost $feedServicePost
     * @return Post
     */
    public function execute(FeedServicePost $feedServicePost): Post
    {
        $post = new Post($feedServicePost->toArray());
        $post->published_at = $feedServicePost->publication_date;
        $post->user_id = $this->getDefaultOwnerId();
        return $post;
    }

    /**
     * Get the default owner ID of imported posts.
     * We only pluck the ID here because we don't need anything else.
     *
     * @return int
     */
    protected function getDefaultOwnerId(): int
    {
        return Cache::rememberForever('default-post-owner', function () {
            return app(User::class)->where('email', config('post.default_owner_email'))->pluck('id')->first();
        });
    }
}
