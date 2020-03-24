<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;

class PayChannelData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Payment\PayChannel';


    /**
     * 查询所有通道信息
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getPayChannels()
    {
        $model = $this->modelclass;
        return $model::get();
    }

    public function getClass($channelid)
    {
        $channelInfo = $this->get($channelid);
        if (empty($channelInfo)) {
            return null;
        }
        return $channelInfo->channel_dealclass;
    }

    public function getClassName($channelid)
    {
        $channelInfo = $this->get($channelid);
        if (empty($channelInfo)) {
            return null;
        }
        return $channelInfo->channel_name;
    }

    public function getClassAll()
    {
        $channelInfo = $this->newitem()->get();
        if (empty($channelInfo)) {
            return null;
        }
        return $channelInfo;
    }

    public function getClassType($channelid)
    {
        $channelInfo = $this->get($channelid);
        if (empty($channelInfo)) {
            return null;
        }
        return $channelInfo->channel_infeetype;
    }

    /**
     * 根据 channelid 创建处理类
     * @param  $channelid
     * @author zhoutao
     * @date   2018.3.29
     */
    public function createData($channelid)
    {
        $channel = $this->getByNo($channelid);
        $class = $channel->channel_dealclass;
        return new $class;
    }
}
