<?php

namespace App\Console\Commands;

use App\Actions\TransformFeedServicePostToModelAction;
use App\Services\FeedService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportPostsFromFeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new posts from the feed API.';

    /**
     * Execute the console command.
     *
     * @param FeedService $feedService
     * @param Log $log
     * @param TransformFeedServicePostToModelAction $transformAction
     * @throw \Throwable
     * @return int
     */
    public function handle(FeedService $feedService, Log $log, TransformFeedServicePostToModelAction $transformAction): int
    {
        try {
            $data = $feedService->fetch();
        } catch(\Throwable $e) {
            if (app()->environment('local')) {
                throw $e;
            }

            $log->error(sprintf("Error while running feed:import command: %s", $e->getMessage()));
            return E_ERROR;
        }

        DB::beginTransaction();

        foreach ($data as $feedServicePost) {
            $post = $transformAction->execute($feedServicePost);
            $post->save();

            $this->info(sprintf('Imported post: %s', $post->title));
        }

        DB::commit();

        return 0;
    }
}
