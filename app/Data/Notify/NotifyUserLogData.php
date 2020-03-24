<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class NotifyUserLogData extends IDatafactory
{

    protected $modelclass = 'App\Model\Notify\NotifyUserLog';

    public function addLog($date,$notifyInfo,$eventInfo,$user,$text,$address)
    {
        $item=$this->newitem();
        $item->notify_logno=DocNoMaker::generate("NUNL");
        $item->notify_no=$notifyInfo->id;
        $item->notify_evt=$eventInfo->id;
        $item->notify_user=$user->id;
        $item->notify_text=$text;
        $item->notify_level=$notifyInfo->notify_level;
        $item->notify_type=$notifyInfo->notify_type;
        $item->notify_address=$address;
        $this->create($item);
        return $item; 
    }
}