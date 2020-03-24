<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class NotifyLogData extends IDatafactory
{

    protected $modelclass = 'App\Model\Notify\NotifyLog';

    public function addLog($date,$notifyInfo)
    {
        $item=$this->newitem();
        $item->notify_no=DocNoMaker::generate("NNL");
        $item->notify_evt=$notifyInfo->notify_event;
        $item->notify_id=$notifyInfo->id;
        $item->notify_name=$notifyInfo->notify_name;
        $item->notify_level=$notifyInfo->notify_level;
        $this->create($item);
        return $item; 
    }
}