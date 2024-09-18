<?php

namespace App\Http\Controllers;

use App\DTO\IdDto;
use App\DTO\ReportDto;
use App\Http\Requests\IdRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ReportRequest;
use App\Services\Facades\ReportFacade;
use App\Traits\GeneralTraits;



class ReportController extends Controller
{
    use GeneralTraits;

    public function Report(ReportRequest $request):jsonResponse
    {
        $dto = ReportDto::report($request);

        $report = ReportFacade::report($dto);

        return $this -> returnData('report', $report);
    }

    public function getAllBooks(): jsonResponse
    {
        $reports = ReportFacade::getReports();

        return $this -> returnData('reports', $reports);
    }

    public function getReport(IdRequest $request): JsonResponse
    {
        $dto = IdDto::id($request);

        $report = ReportFacade::getReport($dto);

        return $this -> returnData('report', $report);
    }



    public function delete(IdRequest $request): void
    {
        $dto = IdDto::id($request);

        ReportFacade::delete($dto);
    }  

}
