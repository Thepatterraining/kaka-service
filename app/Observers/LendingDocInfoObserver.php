<?php
namespace App\Observers;
use App\Http\Utils\RaiseEvent;

class LendingDocInfoObserver
{
    protected $event_queue="";
    use RaiseEvent;
    /**
     * 监听更新操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function updated($data)
    {

        $queueData=(object)array();
        if($data->lending_status=='LDS04'
            && $data->getOriginal('lending_status')!='LDS04'
        ) {
            $this->_addToQueue($data, 'updated'); 

        }  
        return true;
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