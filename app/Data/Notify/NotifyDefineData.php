<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;
use App\Data\Notify\DefineData;

class NotifyDefineData extends IDatafactory
{
    protected $modelclass = 'App\Model\Notify\NotifyDefine'; 
    public function addNotifyDefine($name,$event,$filter=null,$type,$specialClass=null,$level=null,$fmt=null)
    {
        $item=$this->newitem();
        $item->notify_name=$name;
        $item->notify_event=$event;
        $item->notify_filter=$filter;
        $item->notify_type=$type;
        $item->notify_specialclass=$specialClass;
        $item->notify_level=$level;
        $item->notify_fmt=$fmt;
        $this->create($item);
        return $item;
    }

    public function getNotifyInfo($id)
    {
        $item=$this->newitem();
        $result=$item->where('notify_event', $id)->get();
        return $result;
    }

    public function getDefine($name)
    {
        $item=$this->newitem();
        $result=$item->where('notify_name', $name)->first();
        return $result;
    }

    public function getDefines($model_name,$event_name)
    {

        $def_fac = new DefineData();
        $define = $def_fac -> getDefineByEvent($model_name, $event_name);
        if($define == null) {
            return [];
        } 
        $model_class = $this->modelclass;
        $items = $model_class::where('notify_event', $define->id)->get();
        return $items;
    }
}