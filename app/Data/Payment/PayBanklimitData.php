<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;

class PayBanklimitData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Payment\PayBanklimit';


    /**
     * 获取单笔限额
     *
     * @param $bankNo 银行号
     * @param $channelid 通道id
     */
    public function getPertop($bankNo, $channelid)
    {
        $model = $this->modelclass;
        $where['bank_typeno'] = $bankNo;
        $where['channel_id'] = $channelid;
        $info = $model::where($where)->first();
        if (empty($info)) {
            return 0;
        }
        return $info->bank_pertop;
    }

    /**
     * 获取每日限额
     *
     * @param $bankNo 银行号
     * @param $channelid 通道id
     */
    public function getDaytop($bankNo, $channelid)
    {
        $model = $this->modelclass;
        $where['bank_typeno'] = $bankNo;
        $where['channel_id'] = $channelid;
        $info = $model::where($where)->first();
        if (empty($info)) {
            return 0;
        }
        return $info->bank_daytop;
    }
}
