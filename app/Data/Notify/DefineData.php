<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;

class DefineData extends IDatafactory
{
    protected $modelclass = 'App\Model\Notify\Define'; 

    public function addDefine($name,$key,$model,$type,$filter=null,$level=null,$queueType,$observer)
    {
        $item=$this->newitem();
        $item->event_name=$name;    
        $item->event_key=$key;
        $item->event_model=$model;
        $item->event_type=$type;
        $item->event_filter=$filter;
        $item->event_level=$level;
        $item->event_queuetype=$queueType;
        $item->event_observer=$observer;
        $this->create($item);
        return $item;
    }

    public function getEventInfo($event)
    {
        $item=$this->newitem();
        $result=$item->where('id', $event)->first();
        return $result;
    }

    public function getEventInfoByType($event)
    {
        $item=$this->newitem();
        $result=$item->where('event_type', $event)->first();
        return $result;
    }

    public function getDefineByName($name)
    {
        $item=$this->newitem();
        $result=$item->where('event_name', $name)->first();
        return $result;
    }
    public function getDefineByEvent($name,$event)
    {
        $item=$this->newitem();
        $result=$item->where('event_model', $name)->andWhere('event_type', $event)->first();
        return $result;
    }

    //2017.8.16 fix 修复测试服mysql报错的问题 liu
    public function whiteInConfig()
    {
        $res=array();
        $res[0]='App\Model\Sys\LoginLog';
        $items=$this->newitem()->get();
        foreach($items as $item)
        {
            if($item->event_model!=null) {
                $res[]=$item->event_model;
            }   
        }
        return $res;
    }
    
    /**
     * 队列信息创建操作
     *
     * @param   data      object 队列数据
     * @param   jobClass  string model类名
     * @author  liu
     * @version 0.1
     */
    public function getListen($jobClass,$handle)
    {
        $model=$this->newitem();
        $res=$model->where('event_model', $jobClass)->where('event_key', $handle)->first();
        return $res;
    }
}