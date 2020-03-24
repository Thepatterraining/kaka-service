<?php
namespace App\Observers;
use App\Data\Notify\DefineData;
use App\Data\Bonus\ProjBonusData;
use App\Http\Utils\RaiseEvent;

class BonusItemObserver extends ModelObserver{

    use RaiseEvent;
    protected $event_queue="";
    /**
     * 
     */
    public function created($data)
    {
  
    }

    /**
     * 监听分红主表修改操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function updated($data)
    {
        if ($data->bonus_success == 1 
            && $data->getOriginal('bonus_success') != 1
        ) {
            $this->_addToQueue($data, 'updated'); 
        } 
    }

     /**
      * 
      */
    public function deleted($data)
    {
    
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
