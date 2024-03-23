<?php

namespace Modules\Timekeeping\UseCases;

use App\Mail\MonthReport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\User;

class GenerateReport
{
    public function handle(User $user, array $input)
    {
        $input = validator($input, [
            'reference' => ['nullable', 'date'],
        ])->validate();

        Mail::to($user)->queue(new MonthReport(
            ($input['reference'] ?? false) ? Carbon::parse($input['reference']) : now(),
            $user,
        ));
    }
}
