<?php
namespace App\Data\Lending;

use App\Data\IDataFactory;
use App\Data\Sys\CoinAccountData as SysCoinAccountData;
use App\Data\Sys\CoinData;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;
use App\Data\Sys\LockData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\User\CoinJournalData as UserCoinJournalData;
use App\Data\User\CashOrderData;
use App\Data\User\CashAccountData as UserCashAccountData;
use App\Data\Schedule\IMinuteSchedule;
use App\Data\Coin\FrozenData;

class ReturnUserData extends IDatafactory implements IMinuteSchedule
{

    const SYSCOIN_USERRETURN_EVENT_TYPE = 'sysCoin_UserReturn_Check';
    /**
     * 归还申请
     *
     * @param  $no 借入单号
     * @author zhoutao
     * @date   2017.11.9
     */
    public function userReturnSys($no)
    {
        $lk = new LockData();
        $key = 'userReturnSys' . $no;
        $lk->lock($key);

        $date = date('Y-m-d H:i:s');
        DB::beginTransaction();

        //查询数据
        $lendingDocInfoData = new LendingDocInfoData();
        $lendingDocInfo = $lendingDocInfoData->getByNo($no);
        if (!empty($lendingDocInfo)) {
            $coinType = $lendingDocInfo->lending_coin_type;
            $amount = $lendingDocInfo->lending_coin_ammount;
            $status = $lendingDocInfo->lending_status;
            $userid = $lendingDocInfo->lending_lenduser;
            if ($status == LendingDocInfoData::BORROW_SUCCESS_STATUS) {
                //平台代币账户 在途 += 转账数量
                $sysCoinAccount = new SysCoinAccountData();
                $sysCoinAccount->increasePending($no, $coinType, $amount, SysCoinJournalData::USER_RETURN_TYPE, SysCoinJournalData::APPLY_STATUS, $date);

                //用户代币账户 余额 -= 转账数量 在途 += 转账数量
                $userCoinAccountData = new UserCoinAccountData;
                $userCoinAccountData->reduceCashIncreasePending($coinType, $no, $amount, $amount, $userid, UserCoinJournalData::USER_RETURN_TYPE, UserCoinJournalData::APPLY_STATUS, $date);

                //修改状态为归还申请
                $lendingDocInfo->lending_status = LendingDocInfoData::RETURN_STATUS;
                $lendingDocInfo->lending_return_time = $date;
                $lendingDocInfoData->save($lendingDocInfo);
            }
            
        }
        
        
        DB::commit();

        $lk->unlock($key);
        return $no;
    }

    /**
     * 归还审核
     *
     * @param  $no 借入单号
     * @author zhoutao
     * @date   2017.11.9
     */
    public function userReturnSysTrue($no)
    {
        $lk = new LockData();
        $key = 'userReturnSysTrue' . $no;
        $lk->lock($key);

        $date = date('Y-m-d H:i:s');
        DB::beginTransaction();

        //查询数据
        $lendingDocInfoData = new LendingDocInfoData();
        $lendingDocInfo = $lendingDocInfoData->getByNo($no);
        if (!empty($lendingDocInfo)) {
            $coinType = $lendingDocInfo->lending_coin_type;
            $amount = $lendingDocInfo->lending_coin_ammount;
            $status = $lendingDocInfo->lending_status;
            $userid = $lendingDocInfo->lending_lenduser;
            $price = $lendingDocInfo->lending_coin_price;
            if ($status == LendingDocInfoData::RETURN_STATUS) {
                //平台代币账户 在途 -= 转账数量 余额 += 转账数量
                $sysCoinAccount = new SysCoinAccountData();
                $sysCoinAccount->increaseCashReducePending($no, $coinType, $amount, SysCoinJournalData::USER_RETURN_TYPE, SysCoinJournalData::SUCCESS_STATUS, $date);

                //用户代币账户 在途 -= 转账数量
                $userCoinAccountData = new UserCoinAccountData;
                $userCoinAccountData->reducePending($coinType, $no, $amount, $userid, UserCoinJournalData::USER_RETURN_TYPE, UserCoinJournalData::SUCCESS_STATUS, $date);

                $lendingDocInfoData->saveReturnSuccess($no, $date);
                
                //写入用户账单
                $userCashAccountData = new UserCashAccountData;
                $userCashAccount = $userCashAccountData->getByNo($userid);
                $userBalance = $userCashAccount->account_cash;
                $userCashOrderData = new CashOrderData();
                $userCashOrderData->add($no, $price, CashOrderData::USER_RETURN_TYPE, $userBalance, $userid);

                //通知用户
                $this->AddEvent(self::SYSCOIN_USERRETURN_EVENT_TYPE, $userid, $no);
            }
        }

        DB::commit();

        $lk->unlock($key);
        return $no;
    }

    /**
     * 查询到了归还时间的，进行归还
     *
     * @author zhoutao
     * @date   2017.11.10
     */
    public function minuterun()
    {
        $date = date('Y-m-d H:i:s');
        $lendingDocInfoData = new LendingDocInfoData;
        $frozenData = new FrozenData;
        $returns = $lendingDocInfoData->getReturns();
        foreach ($returns as $return) {
            $no = $return->lending_docno;
            $count = $return->lending_coin_ammount;
            $userid = $return->lending_lenduser;
            //解冻
            $frozen = $frozenData->getFrozenByJobNo($no);
            if (!empty($frozen)) {
                $frozenNo = $frozen->frozen_no;
                $frozenData->unFrozen($frozenNo, $count, $date);
                $this->userReturnSys($no);
                $this->userReturnSysTrue($no);
            }
        }
        
    }
}
