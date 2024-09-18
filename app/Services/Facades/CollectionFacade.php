<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class CollectionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CollectionService';
    }
}
