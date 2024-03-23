<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Timekeeping\UseCases\GenerateReport;

class ReportsController extends Controller
{
    /**
     * Gera um relatório do mês referência e envia para o usuário por email.
     *
     * @bodyParam referecen date A data de referencia (o relatório será gerado para o mês todo).
     */
    public function store(Request $request, GenerateReport $report)
    {
        $report->handle($request->user(), $request->all());

        return response(status: Response::HTTP_ACCEPTED);
    }
}
