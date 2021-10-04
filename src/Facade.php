<?php

namespace Illusi03\LaraSearch;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return LaraSearch::class;
    }
}
