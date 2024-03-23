<?php

namespace Modules\Timekeeping\UseCases;

use Modules\Timekeeping\Entities\TimeEntry;

class ListEntriesForUser
{
    public function handle(int $userId)
    {
        return TimeEntry::query()
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }
}
