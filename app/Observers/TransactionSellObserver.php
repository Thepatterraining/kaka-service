<?php
namespace App\Observers;
use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class TransactionSellObserver
{

    use RaiseEvent;
    protected $event_queue="transaction";
    /**
     * 监听卖单建立操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function created($data)
    {
        $coinType=$data->sell_cointype;
        $data->cointype=$coinType;
        $data->messagedetailtype=null;
        $this->_addToQueue($data, 'created', 'trade_sell');     
    }

    /**
     * 监听卖单修改操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function updated($data)
    {
        $coinType=$data->sell_cointype;
        $data->cointype=$coinType;
 
        if(($data->sell_status=="TS03")||($data->sell_status=="TS04")) {
            $this->_addToQueue($data, 'updated', 'trade_sell'); 
        }   
    }

     /**
      * 监听卖单删除操作
      *
      * @param   $data 监听数据
      * @return  mixed
      * @author  liu
      * @version 0.1
      */
    public function deleted($data)
    {
        $coinType=$data->sell_cointype;
        $queueData=(object)array();
        $data->cointype=$coinType;

        $this->_addToQueue($data, 'deleted', 'trade_sell');   
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