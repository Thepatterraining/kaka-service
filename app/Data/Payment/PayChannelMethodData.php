<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;

class PayChannelMethodData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Payment\PayChannelMethod';


    /**
     * 查询方法id
     *
     * @param   $channelid 通道id
     * @author  zhoutao
     * @version 0.1
     */
    public function getMethodsid($channelid)
    {
        $model = $this->modelclass;
        $where['channel_id'] = $channelid;
        $info = $model::where($where)->first();
        $methodid = $info->method_id;
        return $methodid;
    }
}
