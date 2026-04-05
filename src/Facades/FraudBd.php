<?php

namespace FraudBd\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class FraudBd extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fraudbd';
    }
}