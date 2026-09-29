<?php

namespace App\Console\Commands;

use App\Models\JobPost;
use App\Services\ScreeningService;
use Illuminate\Console\Command;

class BackfillScreening extends Command
{
    protected $signature   = 'screening:backfill {--job=}';
    protected $description = 'Score existing applications';

    public function handle(ScreeningService $service): int
    {
        $query = JobPost::query();
        if ($this->option('job')) {
            $query->where('id', $this->option('job'));
        }

        $total = 0;
        $query->chunk(20, function ($jobs) use ($service, &$total) {
            foreach ($jobs as $job) {
                $count = $service->screenJob($job);
                $total += $count;
                $this->info("Job #{$job->id}: {$count} applications scored");
            }
        });

        $this->info("Total scored: {$total}");
        return self::SUCCESS;
    }
}