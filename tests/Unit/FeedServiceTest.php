<?php

namespace Tests\Unit;

use App\Services\FeedService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class FeedServiceTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function test_it_returns_a_populated_collection()
    {
        $this->partialMock(Client::class, function ($mock) {
            $mock->shouldReceive('get')->andReturn(
                new Response(200, ['Content-Type' => 'application/json'], json_encode(['data' => [
                    ['title' => 'Title', 'description' => 'Description', 'publication_date' => '2020-01-01 00:00:00'],
                ]]))
            );
        });

        $collection = app(FeedService::class)->fetch();

        foreach ($collection as $item)
        {
            $this->assertEquals('Title', $item->title);
            $this->assertEquals('Description', $item->description);
            $this->assertEquals('2020-01-01 00:00:00', $item->publication_date);
        }
    }
}
