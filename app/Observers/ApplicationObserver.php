<?php

namespace App\Observers;

use App\Models\Application;
use App\Services\ScreeningService;
use Illuminate\Support\Facades\Log;

class ApplicationObserver
{
    public function created(Application $application): void
    {
        try {
            $job = $application->jobPost;
            if (!$job || !$job->screening_enabled) return;

            $service = app(ScreeningService::class);
            $result  = $service->score($application);

            $application->updateQuietly([
                'screening_score'     => $result['score'],
                'screening_band'      => $result['band'],
                'screening_breakdown' => $result['breakdown'],
                'auto_knocked_out'    => $result['knockout'],
                'knockout_reason'     => $result['knockout_reason'],
                'screened_at'         => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Screening failed', [
                'application_id' => $application->id,
                'error'          => $e->getMessage(),
            ]);
        }
    }
}