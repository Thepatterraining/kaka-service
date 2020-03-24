<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;

class NotifyGroupSetData extends IDatafactory
{
    protected $modelclass = 'App\Model\Notify\NotifyGroupSet'; 
    public function addNotifyGroupSet($defineId,$groupId)
    {
        $item=$this->newitem();
        $item->notify_defineid=$defineId;
        $item->notify_groupid=$groupId;
        $this->create($item);
        return $item;
    }

    public function getSet($defineId,$groupId)
    {
        $item=$this->newitem();
        $result=$item->where('notify_defineid', $defineId)
            ->where('notify_groupid', $groupId)
            ->first();
        return $result;
    }
     
    public function getGroup($notifyId)
    {
        $item=$this->newitem();
        $result=$item->where('notify_defineid', $notifyId)->get();
        return $result;
    }
}