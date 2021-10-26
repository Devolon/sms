<?php

namespace Devolon\Sms;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Devolon\Sms\Skeleton\SkeletonClass
 */
class SmsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }
}
