<?php

namespace App\Policies;

use App\Models\TimeEntry;
use App\Models\User;

class TimeEntryPolicy
{
    public function update(User $user, TimeEntry $entry): bool
    {
        return $user->id === $entry->user_id;
    }
}
