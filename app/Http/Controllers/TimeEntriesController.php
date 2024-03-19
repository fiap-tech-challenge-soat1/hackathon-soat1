<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeEntryResource;
use App\Models\TimeEntry;
use Illuminate\Http\Request;

class TimeEntriesController extends Controller
{
    public function store(Request $request)
    {
        return TimeEntryResource::make($request->user()->entries()->create([
            'started_at' => now(),
        ]));
    }

    public function update(TimeEntry $entry)
    {
        return TimeEntryResource::make(tap($entry)->update([
            'ended_at' => $entry->ended_at ?? now(),
        ]));
    }
}
