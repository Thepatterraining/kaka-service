<?php
namespace App\Loader;
use App\Observers\ModelObserver;
/**
 * 模型加载
 */
class ObserverLoader
{
    public function load()
    {
        $defs = config('event');
        if($defs !=null) {
            foreach ($defs as $modelClass=>$observer){
                $modelClass::observe($observer);
            }
        }
    }
}