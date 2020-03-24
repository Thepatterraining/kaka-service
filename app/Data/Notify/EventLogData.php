<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class EventLogData extends IDatafactory
{

    protected $modelclass = 'App\Model\Notify\EventLog';

    public function addLog($date,$eventInfo)
    {
        $item=$this->newitem();
        $item->event_no=DocNoMaker::generate("NEL");
        $item->event_id=$eventInfo->id;
        $item->event_model=$eventInfo->event_model;
        $item->event_name=$eventInfo->event_name;
        $item->event_data=$eventInfo;
        $this->create($item);
        return $item; 
    }
}