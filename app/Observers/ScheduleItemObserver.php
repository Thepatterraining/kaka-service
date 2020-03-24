<?php
namespace App\Observers;
// use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class ScheduleItemObserver
{

    use RaiseEvent;
    protected $event_queue="";
    /**
     * 监听充值建立操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function created($data)
    {
        $queueData=(object)array();
        if($data->sch_itemname=='用户自定义报表' && $data->sch_defno=="") {
            $this->_addToQueue($data, 'created');
        }   
    }

    private function _addToQueue($data,$event,$messageType = "")
    {
        
        $model_class = get_class($data);
        $queueData=(object)array();
        $queueData->key = $event;
        $queueData->time=date("Y-m-d H:i:s");
        $queueData->event=$model_class;
        $data->queueKey=$event;
        $queueData->data=$data;
        $queueData->messagetype=$messageType;
        $queueData->source=null;
        $this->AddQueueEvent($this->event_queue, $queueData);
    }

}