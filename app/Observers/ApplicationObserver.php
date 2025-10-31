<?php

namespace App\Observers;

use App\Models\Application;
use App\Services\ApplicationSnapshotService;

class ApplicationObserver
{
    public function created(Application $application): void
    {
        app(ApplicationSnapshotService::class)->createFor($application);
    }
}
