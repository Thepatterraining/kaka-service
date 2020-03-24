<?php
namespace App\Data\CashRecharge;

/**
 * 现金充值的接口
 *
 * @author  zhoutao
 * @date    2017.11.21
 * @version 1.0
 **/
interface ICashRecharge
{


    /** 
     * 申请充值
     *
     * @param   $amount 充值金额
     * @param   $bankCard 充值卡号
     * @param   $mobile 手机号
     * @author  zhoutao
     * @date    2017.11.21
     * @version 1.0
     **/
     
    public function recharge($amount, $bankCard, $mobile);

    /** 
     * 充值审核成功
     *
     * @param   $rechargeNo 充值号
     * @author  zhoutao
     * @date    2017.11.21
     * @version 1.0
     **/
    public function rechargeTrue($rechargeNo, $code);

    /** 
     * 充值审核拒绝
     *
     * @param   $rechargeNo 充值号
     * @author  zhoutao
     * @date    2017.11.21
     * @version 1.0
     **/
    public function rechargeFalse($rechargeNo);


    /**
     * 发送短信
     *
     * @param  $rechargeNo 充值单
     * @param  $mobile 手机号
     * @author zhoutao
     * @date   2017.11.23
     */
    public function sendSms($rechargeNo, $mobile);
}