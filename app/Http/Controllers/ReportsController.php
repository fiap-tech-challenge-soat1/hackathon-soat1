<?php

namespace App\Http\Controllers;

use App\Mail\MonthReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reference' => ['nullable', 'date'],
        ]);

        Mail::to($request->user())->queue(new MonthReport(
            $request->date('reference') ?: now(),
            $request->user(),
        ));

        return response(status: Response::HTTP_ACCEPTED);
    }
}
