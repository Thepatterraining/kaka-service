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

class LendingUserData extends IDatafactory
{
    const USER_COIN_ACCOUNT_TYPE = false;

    /**
     * 平台给用户转账
     *
     * @param   $coinType 代币类型
     * @param   $amount 借入数量
     * @param   $userid 用户id
     * @param   $planReturnTime 计划归还时间
     * @param   $price 借入价格
     * @author  zhoutao
     * @version 0.1
     * @date    2017.11.9
     * 
     * 用户没有增加账户
     * @author  zhoutao
     * @date    2017.11.13
     */
    public function sysToUser($coinType, $amount, $userid, $planReturnTime, $price)
    {
        $lk = new LockData();
        $key = 'sysToUser' . $coinType;
        $lk->lock($key);

        $date = date('Y-m-d H:i:s');

        DB::beginTransaction();

        //查询用户有没有这个币种
        $userCoin = new UserCoinAccountData();

        //查询有没有，没有就增加普通账户
        $userCoinInfo = $userCoin->getUserCoin($coinType, $userid);
        if (empty($userCoinInfo)) {
            $userCoin->addUserCoin($coinType, $userid, self::USER_COIN_ACCOUNT_TYPE);
        }

        //创建拆解
        $lendingDocInfoData = new LendingDocInfoData;
        $no = $lendingDocInfoData->add($coinType, $amount, $price, $userid, LendingDocInfoData::NOVICE_TYPE, LendingDocInfoData::BORROW_STATUS, $planReturnTime, $date);

        //平台代币账户 在途增加 -= 转账数量 余额 -= 转账数量
        $sysCoinAccount = new SysCoinAccountData();
        $sysCoinAccount->reduceCashIncreasePending($no, $coinType, $amount, SysCoinJournalData::TO_USER_TYPE, SysCoinJournalData::APPLY_STATUS, $date);

        //用户代币账户 在途增加 += 转账数量
        $userCoinAccountData = new UserCoinAccountData;
        $userCoinAccountData->increasePending($coinType, $no, $amount, $userid, UserCoinJournalData::SYS_TO_USER_TYPE, UserCoinJournalData::APPLY_STATUS, $date);
        
        DB::commit();
        $lk->unlock($key);

        return $no;
    }

    /**
     * 审核成功
     *
     * @param   $no 单据号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.11.9
     */
    public function sysToUserTrue($no)
    {
        $lk = new LockData();
        $key = 'sysToUserConfirm' . $no;
        $lk->lock($key);

        $date = date('Y-m-d H:i:s');
        //查询数据
        $lendingDocInfoData = new LendingDocInfoData();
        $lendingDocInfo = $lendingDocInfoData->getByNo($no);
        if (!empty($lendingDocInfo)) {
            $coinType = $lendingDocInfo->lending_coin_type;
            $amount = $lendingDocInfo->lending_coin_ammount;
            $status = $lendingDocInfo->lending_status;
            $userid = $lendingDocInfo->lending_lenduser;
            $price = $lendingDocInfo->lending_coin_price;
            
            if ($status == LendingDocInfoData::BORROW_STATUS) {
                DB::beginTransaction();

                //平台代币账户 在途减少 -= 转账数量
                $sysCoinAccount = new SysCoinAccountData();
                $sysCoinAccount->reducePending($no, $coinType, $amount, SysCoinJournalData::TO_USER_TYPE, SysCoinJournalData::SUCCESS_STATUS, $date);

                //用户代币账户 在途增加 -= 转账数量 余额 += 转账数量
                $userCoinAccountData = new UserCoinAccountData;
                $userCoinAccountData->increaseCashReducePending($coinType, $no, $amount, $amount, $userid, UserCoinJournalData::SYS_TO_USER_TYPE, UserCoinJournalData::SUCCESS_STATUS, $date);
                
                //更新拆解表
                $lendingDocInfoData->saveBorrowSuccess($no, $date);

                //写入用户账单
                $userCashAccountData = new UserCashAccountData;
                $userCashAccount = $userCashAccountData->getByNo($userid);
                $userBalance = $userCashAccount->account_cash;
                $userCashOrderData = new CashOrderData();
                $userCashOrderData->add($no, $price, CashOrderData::BORROW_TYPE, $userBalance, $userid);

                DB::commit();
            }
            
        }

        $lk->unlock($key);
        return $no;
        
    }

}
