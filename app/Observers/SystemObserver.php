<?php
namespace App\Observers;

use App\Http\Utils\RaiseEvent;
/**
 * 通用的业务类
 * 只负责把相应事件放到系统队列中
 * 
 * @author  老拐 <geyunfei@kakamf.com>
 * @version Release: <2.3.2>
 * @date    2017-11-21
 */
class SystemObserver
{
    use RaiseEvent;
    protected $event_queue=null;

    public function created($data)
    {
         $this->_addToQueue($data, 'created');
      
    }

    public function updated($data)
    {
        $this->_addToQueue($data, 'updated');

    }
    public function deleted($data)
    {
        $this->_addToQueue($data, "deleted");
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