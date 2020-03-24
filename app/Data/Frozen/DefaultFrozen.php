<?php
namespace App\Data\Frozen;

use App\Data\Voucher\IVoucher ;
use App\Data\Coin\FrozenData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\User\CoinJournalData as UserCoinJournalData;

class DefaultFrozen implements IFrozen
{

    private $frozenType;

    /**
     * 加载数据
     *
     * @param   $frozenType 冻结类型
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.8
     * @return 
     **/
    public function load_data($frozenType)
    {
        $this->frozenType = $frozenType;
    }

    /**
     * 对某笔交易冻结
     *
     * @param   $orderNo 成交单号
     * @param   $date 时间
     * @param   $freezetime 冻结时间
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.8
     * @return 
     * true 成功
     * false 失败
     */
    public function orderFrozen($orderNo, $date, $freezetime = 0)
    {
        if (empty($this->frozenType)) {
            return '';
        }
        
        //查询交易
        $orderData = new TranactionOrderData;
        $order = $orderData->getByNo($orderNo);
        if (empty($order)) {
            return '';
        }

        $amount = $order->order_amount;
        $buyCashFee = $order->order_buycash_fee;
        $buyUserid = $order->order_buy_userid;
        $count = $order->order_count;
        $coinType = $order->order_coin_type;

        $accountData = new UserCoinAccountData();
        $accountid = $accountData->getAccountid($coinType, $buyUserid);

        //写入冻结表
        $data = new FrozenData();
        $frozenNo = $data->add($coinType, $accountid, $buyUserid, $orderNo, $freezetime, $this->frozenType);

        //用户代币表 因为冻结，在途增加 += 冻结个数 余额 -= 冻结个数
        $accountRes = $accountData->reduceCashIncreasePending($coinType, $frozenNo, $count, $count, $buyUserid, UserCoinJournalData::FROZEN_TYPE, UserCoinJournalData::FROZEN_STATUS, $date);
        return true;
    }
}