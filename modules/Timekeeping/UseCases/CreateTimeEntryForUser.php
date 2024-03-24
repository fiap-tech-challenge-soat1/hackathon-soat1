<?php

namespace Modules\Timekeeping\UseCases;

use Modules\Timekeeping\Entities\TimeEntry;

class CreateTimeEntryForUser
{
    public function handle(int $userId): TimeEntry
    {
        return TimeEntry::create([
            'user_id' => $userId,
            'started_at' => now(),
        ]);
    }
}
