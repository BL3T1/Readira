<?php

namespace App\DTO;

use App\Http\Requests\ReportRequest;
use App\Models\User;

class ReportDto
{
    public function __construct(
        public readonly User $user,
        public readonly string $reason,
        public readonly string $report,


    )
    {
    }

    public static function report(ReportRequest $request): ReportDto
    {
        return new self(
            user: $request->user(),
            reason: $request->reason,
            report: $request->report,


        );
    }
}
