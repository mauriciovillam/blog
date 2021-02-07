<?php

namespace App\Actions;

use App\Models\Post;
use Illuminate\Contracts\Auth\Authenticatable;

class CreatePostAction
{
    /**
     * Create a post and store it in the database.
     * @param array $data
     * @param Authenticatable $user
     */
    public function execute(array $data, Authenticatable $user)
    {
        $post = new Post;
        $post->fill($data);
        $post->user()->associate($user);
        $post->save();
    }
}
