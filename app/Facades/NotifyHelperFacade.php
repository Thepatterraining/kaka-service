<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the notify helper facade class.
 *
 * @author lijie
 */
class NotifyHelperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'notifyhelper';
    }
}
