<?php
namespace App\Observers;
// use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class RechargeObserver extends ModelObserver
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
        $this->_addToQueue($data, 'created');
    }

    public function updated($data)
    {
        if($data->cash_recharge_success==1 && $data->getOriginal('cash_recharge_success')==0) {
            $this->_addToQueue($data, 'updated');  
        }
    }

    public function deleted($data)
    {
        $this->_addToQueue($data, 'deleted');   
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