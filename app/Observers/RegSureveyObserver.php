<?php
namespace App\Observers;
// use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class RegSurveyObserver
{

    use RaiseEvent;
    protected $event_queue="";
    
    /**
     * 监听注册操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.11.22
     */
    public function created($data)
    {
        $queueData=(object)array();

        $this->_addToQueue($data, 'created');  
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