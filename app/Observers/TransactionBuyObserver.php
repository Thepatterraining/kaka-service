<?php
namespace App\Observers;
use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class TransactionBuyObserver
{

    use RaiseEvent;
    protected $event_queue="transaction";
    /**
     * 监听买单建立操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function created($data)
    {
        $coinType=$data->buy_cointype;
        $data->cointype=$coinType;
        $this->_addToQueue($data, 'created', 'trade_buy');
    }

    /**
     * 监听买单修改操作
     *
     * @param   $data 监听数据  
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function updated($data)
    {
        $coinType=$data->buy_cointype;
        $data->cointype=$coinType;
        $messageType='trade_buy';
        if((($data->buy_status=="TB03")||($data->buy_status=="TB04"))  
            && $data->buy_status!=$data->getOriginal('buy_status')
        ) {
            $this->_addToQueue($data, 'updated', 'trade_buy');
        }
    }

     /**
      * 监听买单删除操作
      *
      * @param   $data 监听数据
      * @return  mixed
      * @author  liu
      * @version 0.1
      */
    public function deleted($data)
    {
        $coinType=$data->buy_cointype;
        $data->cointype=$coinType;
        $data->detailtype=null;
        $messageType='trade_buy';
        $this->_addToQueue($data, 'deleted', 'trade_buy');   
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