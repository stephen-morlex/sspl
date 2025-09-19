<?php

namespace App\Jobs;

use App\Models\MatchEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteStatsJob implements ShouldQueue
{
    use Queueable;

    public MatchEvent $event;

    /**
     * Create a new job instance.
     */
    public function __construct(MatchEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Dispatch the UpdateStatsJob with deletion flag set to true
        UpdateStatsJob::dispatch($this->event, true);
    }
}
