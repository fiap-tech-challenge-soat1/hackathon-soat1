<?php

namespace Modules\Timekeeping\UseCases;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Timekeeping\Entities\TimeEntry;

class UpdateTimeEntry
{
    use AuthorizesRequests;

    public function handle(TimeEntry $entry)
    {
        $this->authorize('update', $entry);

        return tap($entry)->update([
            'ended_at' => $entry->ended_at ?? now(),
        ]);
    }
}
