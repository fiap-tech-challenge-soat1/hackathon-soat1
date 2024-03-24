<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeEntryResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Timekeeping\Entities\TimeEntry;
use Modules\Timekeeping\UseCases\CreateTimeEntryForUser;
use Modules\Timekeeping\UseCases\ListEntriesForUser;
use Modules\Timekeeping\UseCases\UpdateTimeEntry;

class TimeEntriesController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista os pontos do usuário atual.
     *
     * @apiResourceCollection \App\Http\Resources\TimeEntryResource
     *
     * @apiResourceModel \Modules\Timekeeping\Entities\TimeEntry
     */
    public function index(Request $request, ListEntriesForUser $lister)
    {
        return TimeEntryResource::collection(
            $lister->handle($request->user()->id)
        );
    }

    /**
     * Registra um novo ponto.
     *
     * @apiResource \App\Http\Resources\TimeEntryResource
     *
     * @apiResourceModel \Modules\Timekeeping\Entities\TimeEntry
     */
    public function store(Request $request, CreateTimeEntryForUser $creator)
    {
        return TimeEntryResource::make(
            $creator->handle($request->user()->id)
        );
    }

    /**
     * Atualiza um ponto (marca como finalizado).
     *
     * @apiResource \App\Http\Resources\TimeEntryResource
     *
     * @apiResourceModel \Modules\Timekeeping\Entities\TimeEntry
     */
    public function update(TimeEntry $entry, UpdateTimeEntry $updater)
    {
        return TimeEntryResource::make(
            $updater->handle($entry)
        );
    }
}
