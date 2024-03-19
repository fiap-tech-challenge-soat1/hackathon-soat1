<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeEntryResource;
use App\Models\TimeEntry;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TimeEntriesController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista os pontos do usuário atual.
     *
     * @apiResourceCollection \App\Http\Resources\TimeEntryResource
     * @apiResourceModel \App\Models\TimeEntry
     */
    public function index(Request $request)
    {
        return TimeEntryResource::collection(
            $request->user()->entries()->latest()->get(),
        );
    }

    /**
     * Registra um novo ponto.
     *
     * @apiResource \App\Http\Resources\TimeEntryResource
     * @apiResourceModel \App\Models\TimeEntry
     */
    public function store(Request $request)
    {
        return TimeEntryResource::make($request->user()->entries()->create([
            'started_at' => now(),
        ]));
    }

    /**
     * Atualiza um ponto (marca como finalizado).
     *
     * @apiResource \App\Http\Resources\TimeEntryResource
     * @apiResourceModel \App\Models\TimeEntry
     */
    public function update(TimeEntry $entry)
    {
        $this->authorize('update', $entry);

        return TimeEntryResource::make(tap($entry)->update([
            'ended_at' => $entry->ended_at ?? now(),
        ]));
    }
}
