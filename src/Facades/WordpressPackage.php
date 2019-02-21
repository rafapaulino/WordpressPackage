<?php

namespace rafapaulino\WordpressPackage\Facades;

use Illuminate\Support\Facades\Facade;

class WordpressPackage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wordpresspackage';
    }
}
