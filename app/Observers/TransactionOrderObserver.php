<?php
namespace App\Observers;
use App\Data\Notify\DefineData;
use App\Http\Utils\RaiseEvent;

class TransactionOrderObserver
{

    use RaiseEvent;
    protected $event_queue="transaction";
    /**
     * 监听交易建立操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function created($data)
    {
        $coinType=$data->order_coin_type;
        $data->cointype=$coinType;
        //平米总价
        $price=$data->order_price;
        //每份包含平米数
        $scale=$data->order_scale;
        //每份价格
        $data->latestprice = $price * $scale;
        //卖方id
        $data->orderselluserid=$data->order_sell_userid;
        //买方id
        $data->orderbuyuserid=$data->order_buy_userid;

        $this->_addToQueue($data, 'created', 'trade_order');    
    }

    /**
     * 监听交易修改操作
     *
     * @param   $data 监听数据
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function updated($data)
    {
        $coinType=$data->order_coin_type;

        $data->cointype=$coinType;
        //平米总价
        $price=$data->order_price;
        //每份包含平米数
        $scale=$data->order_scale;
        //每份价格
        $data->latestprice = $price * $scale;
        //卖方id
        $data->orderselluserid=$data->order_sell_userid;
        //买方id
        $data->orderbuyuserid=$data->order_buy_userid;

        $this->_addToQueue($data, 'updated', 'trade_order');    
    }

     /**
      * 监听交易删除操作
      *
      * @param   $data 监听数据
      * @return  mixed
      * @author  liu
      * @version 0.1
      */
    public function deleted($data)
    {
        $coinType=$data->order_coin_type;

        $data->cointype=$coinType;
        //平米总价
        $price=$data->order_price;
        //每份包含平米数
        $scale=$data->order_scale;
        //每份价格
        $data->latestprice = $price * $scale;
        //卖方id
        $data->orderselluserid=$data->order_sell_userid;
        //买方id
        $data->orderbuyuserid=$data->order_buy_userid;

        $this->_addToQueue($data, 'deleted', 'trade_order');        
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