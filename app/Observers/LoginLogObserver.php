<?php
namespace App\Observers;
// use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class LoginLogObserver extends ModelObserver
{

    use RaiseEvent;
    protected $channel_id="kk_event";
    protected $js_id="kk_js_event";
    protected $event_queue="";
    /**
     * 监听登录记录建立操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function created($data)
    {
        $this->_addToQueue($data, 'updated');    
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