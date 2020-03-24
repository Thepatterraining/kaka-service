<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class WithdrawalData extends IDatafactory
{

    protected $no = 'coin_withdrawal_no';

    protected $modelclass = 'App\Model\Coin\Withdrawal';


    /**
     * 添加提现
     *
     * @param   $no 单据号
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @param   $userid 用户id
     * @param   $address 用户钱包地址
     * @param   $rate 手续费率
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addWithdrawal($no, $coinType, $amount, $userid, $address, $rate, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->newitem();
        $model->coin_withdrawal_no = $no;
        $model->coin_withdrawal_cointype = $coinType;
        $model->coin_withdrawal_amount = $amount;
        $model->coin_withdrawal_status = 'OW00';
        $model->coin_withdrawal_userid = $userid;
        $model->coin_withdrawal_time = $date;
        $model->coin_withdrawal_toaddress = $address;
        $model->coin_withdrawal_fromaddress = 'null';
        $model->coin_withdrawal_type = 'OWT01';
        $model->coin_withdrawal_rate = $rate;
        $model->coin_withdrawal_fee = $amount * $rate;
        return $model->save();
    }

    /**
     * 查询提现
     *
     * @param   $no 单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getWithdrawal($no)
    {
        $where['coin_withdrawal_no'] = $no;
        return $this->findForUpdate($where);
    }

    /**
     * 更新提现
     *
     * @param   $no 单据号
     * @param   $amount 实际提现数量
     * @param   $status 状态
     * @param   $success 是否成功
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveWith($no, $amount, $status, $success, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getWithdrawal($no);
        $model->coin_withdrawal_status = $status;
        $model->coin_withdrawal_chkuserid = $this->session->userid;
        $model->coin_withdrawal_chktime = $date;
        $model->coin_withdrawal_success = $success;
        $model->coin_withdrawal_out = $amount;
        return $model->save();
    }
}
