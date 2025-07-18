<?php

namespace IlBronza\Timings\Facades;

use Illuminate\Support\Facades\Facade;

class Timings extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'timings';
    }
}
