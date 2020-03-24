<?php
namespace App\Data\Cash\Withdrawal;

/**
 * 图形验证码的接口
 *
 * @author  zhoutao
 * @date    2017.8.31
 * @version 1.0
 **/
interface ICashWithdrawal
{


    /** 
     * 发起提现
     *
     * @param   $amou 提现金额
     * @param   $userBankId 用户银行卡
     * @param   $bankNo 银行号
     * @param   $name 用户姓名
     * @param   $branchName 支行
     * @author  zhoutao
     * @date    2017.11.27
     * @version 1.0
     **/
    public function withdrawal($amount, $userBankId, $bankNo, $name, $branchName);

    /** 
     * 提现审核成功
     *
     * @param   $withdrawalNo 提现单号
     * @param   $desBank 提现卡号
     * @author  zhoutao
     * @date    2017.11.27
     * @version 1.0
     **/
    public function withdrawalTrue($withdrawalNo, $desBank);

    /** 
     * 提现审核拒绝
     *
     * @param   $withdrawalNo 提现单号
     * @param   $body 描述
     * @author  zhoutao
     * @date    2017.11.27
     * @version 1.0
     **/
    public function withdrawalFalse($withdrawalNo, $body);
}