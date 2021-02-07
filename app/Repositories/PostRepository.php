<?php

namespace App\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;

class PostRepository
{
    const DEFAULT_SORT = 'desc';

    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get a collection of posts, this is can be sorted
     *
     * @param string|null $sort
     * @return Collection
     */
    public function all(?string $sort = self::DEFAULT_SORT): Collection
    {
        $sort = $sort ? strtolower($sort) : self::DEFAULT_SORT;
        return Cache::rememberForever($this->formatCacheKey($sort), function () use ($sort) {
           return $this->post->orderBy('published_at', $sort)->get();
        });
    }

    /**
     * Get a collection of posts made by a certain user.
     * @param Authenticatable $user
     * @param string|null $sort
     * @return mixed
     */
    public function findByUser(Authenticatable $user, ?string $sort = self::DEFAULT_SORT)
    {
        $sort = $sort ? strtolower($sort) : self::DEFAULT_SORT;
        return Cache::rememberForever($this->formatCacheKey($sort, $user), function () use ($sort, $user) {
            return $this->post
                ->with(['user'])
                ->where('user_id', $user->getAuthIdentifier())
                ->orderBy('published_at', $sort)
                ->get();
        });
    }

    /**
     * This is used when a post is created or updated.
     * @param Authenticatable|null $user clear cache of the posts of a specific User instead of all the posts.
     */
    public function clearCache(Authenticatable $user = null): void
    {
        if (!empty($user)) {
            Cache::forget($this->formatCacheKey('asc', $user));
            Cache::forget($this->formatCacheKey('desc', $user));
        }
        else {
            Cache::forget($this->formatCacheKey('asc'));
            Cache::forget($this->formatCacheKey('desc'));
        }
    }

    /**
     * Helper function to format the cache key for a given sort option or user.
     * @param string $sort
     * @param Authenticatable |null $user
     * @return string
     */
    protected function formatCacheKey(string $sort, ?Authenticatable $user = null): string
    {
        if (!empty($user)) {
            return sprintf('posts:user:%d:%s', $user->getAuthIdentifier(), $sort);
        } else return sprintf('posts:%s', $sort);
    }
}
