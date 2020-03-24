<?php
namespace Cybereits\Common\Event; 
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