<?php

namespace App\Services\Contracts;

use App\DTO\IdDto;
use App\DTO\ReportDto;
use App\Models\Report;
use \Illuminate\Database\Eloquent\Collection;

interface ReportContract
{
    public function report(ReportDto $data):report;

    public function getReports(): Collection;

    public function getReport(IdDto $data): Collection;

    public function deleteReport(IdDto $data): void;

  
}
