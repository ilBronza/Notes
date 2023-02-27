<?php

namespace IlBronza\Notes\Facades;

use Illuminate\Support\Facades\Facade;

class Notes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'notes';
    }
}
