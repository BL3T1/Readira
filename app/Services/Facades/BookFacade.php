<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class BookFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'BookService';
    }
}
