<?php
namespace App\Data\Frozen;

use App\Data\Voucher\IVoucher ;
use App\Data\Coin\FrozenData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\User\CoinJournalData as UserCoinJournalData;
use App\Data\Lending\LendingDocInfoData;

class LendingFrozen implements IFrozen
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
     * 拆解冻结
     *
     * @param   $lendingNo 拆解单号
     * @param   $date 时间
     * @param   $freezetime 冻结时间
     * @author  zhoutao
     * @version 1.0
     * @date    2017.11.9
     */
    public function orderFrozen($lendingNo, $date = 0, $freezetime = 0)
    {
        if (empty($this->frozenType)) {
            return '';
        }
        
        //查询交易
        $lendingDocInfoData = new LendingDocInfoData;
        $lendingDocInfo = $lendingDocInfoData->getByNo($lendingNo);
        if (empty($lendingDocInfo)) {
            return '';
        }

        $amount = $lendingDocInfo->order_amount;
        $userid = $lendingDocInfo->lending_lenduser;
        $count = $lendingDocInfo->lending_coin_ammount;
        $coinType = $lendingDocInfo->lending_coin_type;
        $freezetime = $lendingDocInfo->lending_plan_returntime;
        $date = $lendingDocInfo->lending_lendtime;

        $accountData = new UserCoinAccountData();
        $accountid = $accountData->getAccountid($coinType, $userid);

        //写入冻结表
        $data = new FrozenData();
        $freezetime = date('Y-m-d H:i:s', strtotime($freezetime . '+1 hour'));
        $frozenNo = $data->add($coinType, $accountid, $userid, $lendingNo, $freezetime, $this->frozenType);

        //用户代币表 因为冻结，在途增加 += 冻结个数 余额 -= 冻结个数
        $accountRes = $accountData->reduceCashIncreasePending($coinType, $frozenNo, $count, $count, $userid, UserCoinJournalData::FROZEN_TYPE, UserCoinJournalData::FROZEN_STATUS, $date);
        return $frozenNo;
    }
}