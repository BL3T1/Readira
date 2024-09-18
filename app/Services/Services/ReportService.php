<?php

namespace App\Services\Services;

use App\DTO\IdDto;
use App\DTO\ReportDto;
use App\Models\Report;
use App\Services\Contracts\ReportContract;
use \Illuminate\Database\Eloquent\Collection;

class ReportService implements ReportContract
{

    public function report(ReportDto $data):report{
        $report = Report::create([
            'user_id'=>$data ->user->id,
            'reason'=>$data->reason,
            'report'=>$data->report,
        ]);
        return $report;

    }



    public function getReport(IdDto $data): Collection
    {
        $Report = Report::with('users')
            -> get();
        return  $Report;
    }

    public function deleteReport(IdDto $data): void
    {
        Report::where('user_id', $data->user->id)
            -> where('id', $data->id)
            -> delete();
    }

    public function getReports(): Collection
    {
        $reports = Report::all();

        return $reports;
    }
}