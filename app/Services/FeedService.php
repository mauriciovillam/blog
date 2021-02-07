<?php

namespace App\Services;

use App\Data\Collections\FeedServicePostCollection;
use GuzzleHttp\Exception\GuzzleException;
use App\Data\FeedServicePost;
use GuzzleHttp\Client;
use RuntimeException;

class FeedService
{
    protected string $baseUrl;

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->baseUrl = config('services.feed.url');
    }

    /**
     * Fetch a list of new posts from the Feed API.
     *
     * @return FeedServicePostCollection
     * @throws GuzzleException
     */
    public function fetch(): FeedServicePostCollection
    {
        $data = json_decode(
            $this->client->get($this->baseUrl)->getBody()->getContents(),
            true
        );

        if (empty($data)) {
            throw new RuntimeException('Unexpected data parsing issues or blank data returned by the Feed API.');
        }

        $posts = [];
        foreach ($data['data'] as $post) {
            $posts[] = new FeedServicePost($post);
        }

        return new FeedServicePostCollection($posts);
    }
}
