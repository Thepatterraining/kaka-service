<?php
namespace App\Observers;
use App\Data\Notify\DefineData;
use App\Data\Bonus\ProjBonusData;
use App\Http\Utils\RaiseEvent;

class BonusObserver
{
    use RaiseEvent;
    protected $event_queue="";
    /**
     * 
     */
    public function created($data)
    {
        $queueData=(object)array();

        $this->_addToQueue($data, 'created');   
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
        //  dump($data);
        if ($data->bonus_status == ProjBonusData::SUCCESS_STATUS 
            && $data->getOriginal('bonus_status') != ProjBonusData::SUCCESS_STATUS
        ) {
            $this->_addToQueue($data, 'updated'); 
        } 
    }

     /**
      * 
      */
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
