<?php

namespace App\Services\Facades;
use Illuminate\Support\Facades\Facade;

class ReportFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ReportService';
    }
}
