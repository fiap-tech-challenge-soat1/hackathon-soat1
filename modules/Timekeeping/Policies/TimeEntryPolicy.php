<?php

namespace Modules\Timekeeping\Policies;

use Modules\Timekeeping\Entities\TimeEntry;
use Modules\User\Entities\User;

class TimeEntryPolicy
{
    public function update(User $user, TimeEntry $entry): bool
    {
        return $user->is($entry->user);
    }
}
