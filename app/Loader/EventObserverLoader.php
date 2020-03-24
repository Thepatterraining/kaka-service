<?php
namespace App\Loader;
use App\Observers\EventObserver;
use App\Model\Notify\Define;

class EventObserverLoader
{


    public function load()
    {
        Define::observe(EventObserver::class);
    }
}