<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Sys\CoinAccountData;
use App\Data\Sys\CoinData;
use App\Data\User\CoinJournalData;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;
use App\Data\Sys\UserData;
use App\Data\Utils\DocMD5Maker;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Model\User\CoinAccount;
use Illuminate\Support\Facades\DB;

class CoinWithdrawalData extends IDatafactory
{
    /**
     * 提现代币业务
     *
     * @param   $coinType 代币类型
     * @param   $userid 用户id
     * @param   $amount 充值数量
     * @param   $no 充值单据号
     * @param   $coinJournalNo 系统代币流水单据号
     * @param   $sysCoinJournalNo 系统流水单据号
     * @param   $userCoinJournalNo 用户流水单据号
     * @param   $feeNo 手续费单据号
     * @param   $address 用户提现地址
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function withdrawal($coinType, $userid, $amount, $no, $coinJournalNo, $sysCoinJournalNo, $userCoinJournalNo, $feeNo, $address, $date)
    {
        $withdrawalRate = config("trans.withdrawalcoinfeerate");

        $coinSmall = config("trans.ordercoinsmall");

        $outAmount = $amount - $withdrawalRate * $amount;
        $fee = $withdrawalRate * $amount;

        //判断是否用最小手续费
        if ($fee < $coinSmall) {
            $fee = $coinSmall;
        }


        //查找用户信息
        //        $user = new UserData();
        //        $userInfo = $user->getUser($userid);

        //创建钱包地址
        //        $addressData = new AddressData();
        //        $address = $addressData->createAddress($coinType,$userid,$userInfo->user_name,$userInfo->user_idno);


        DB::beginTransaction();
        //查询系统里面有没有这个币种
        //        $sysCoin = new CoinData();
        //        $sysCoinInfo = $sysCoin->getCoin($coinType);
        //        if ($sysCoinInfo === null) {
        //            $sysCoinRes = $sysCoin->addCoin($coinType,$address);
        //            if ($sysCoinRes === false) {
        //                DB::rollBack();
        //                return false;
        //            }
        //        }

        //代币提现表添加数据
        $coinRecharge = new WithdrawalData();
        $coinRechargeRes = $coinRecharge->addWithdrawal($no, $coinType, $amount, $userid, $address, $withdrawalRate, $date);
        if ($coinRechargeRes === false) {
            DB::rollBack();
            return false;
        }

        //代币余额 在途增加 += 提现数量 - 手续费
        $sysCoin = new CoinData();
        $sysCoinRes = $sysCoin->saveCoin($coinType, $outAmount, $date);
        if ($sysCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //代币流水 在途增加 = 提现数量
        $sysCoinJournal = new JournalData();
        $sysJournalRes = $sysCoinJournal->addJournal($sysCoinJournalNo, $coinType, $outAmount, $no, $sysCoinRes, 'CJ01', 'CJT01', 0, 0, $date);
        if ($sysJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币账户
        $userCoin = new UserCoinAccountData();
        //判断用户账户的钱足够
        $usercoinRes = $userCoin->isCash($coinType, $amount);
        if ($usercoinRes === false) {
            DB::rollBack();
            return false;
        }

        // 在途增加 += 提现数量 可用减少 -= 提现数量
        $userCoinRes = $userCoin->saveUserCoin($coinType, $amount, $userid, $date);
        if ($userCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途增加 = 提现数量 - 手续费 支出增加 = 提现数量 - 手续费
        $userJournal = new CoinJournalData();
        $userCoinJournal['pending'] = $userCoinRes['pending'] - $fee;
        $userCoinJournal['cash'] = $userCoinRes['cash'] + $fee;
        $userCoinJournal['id'] = $userCoinRes['id'];
        $userJournalRes = $userJournal->addCoinJournal($userCoinJournal, $coinType, $userCoinJournalNo, $outAmount, $no, 'CJT01', 'UOJ02', 0, $outAmount, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途增加 = 手续费 支出增加 = 手续费
        $userJournalRes = $userJournal->addCoinJournal($userCoinRes, $coinType, $userCoinJournalNo, $fee, $no, 'CJT01', 'UOJ03', 0, $fee, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //系统代币账户 在途增加 += 手续费
        $coinAccount = new CoinAccountData();
        $coinAccountRes = $coinAccount->saveCoin($coinType, $fee, $date);
        if ($coinAccountRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //系统代币流水表 在途增加 = 手续费
        $coinJournal = new SysCoinJournalData();
        $coinJournalRes = $coinJournal->addJournal($coinJournalNo, $fee, $no, $coinAccountRes, $coinType, 'COJ01 ', 'OJT01', 0, 0, $date);
        if ($coinJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //代币手续费表增加数据
        $coinFee = new FeeData();
        $feeRes = $coinFee->addFee($feeNo, $no, $coinType, $fee, $withdrawalRate, 'CWF00', 'CWFT01', $date);
        if ($feeRes === false) {
            DB::rollBack();
            return false;
        }


        DB::commit();
        return true;
    }

    /**
     * 审核成功
     *
     * @param   $no 单据号
     * @param   $sysCoinJournalNo 系统流水单据号
     * @param   $userCoinJournalNo 用户流水单据号
     * @param   $coinJournalNo 系统代币流水单据号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function TrueWithdrawal($no, $sysCoinJournalNo, $userCoinJournalNo, $coinJournalNo, $date)
    {
        //查询代币提现表数据
        $coinRecharge = new WithdrawalData();
        $coinRechargeInfo = $coinRecharge->getWithdrawal($no);
        $coinType = $coinRechargeInfo->coin_withdrawal_cointype;
        $amount = $coinRechargeInfo->coin_withdrawal_amount;
        $userid = $coinRechargeInfo->coin_withdrawal_userid;

        $withdrawalRate = config("trans.withdrawalcoinfeerate");

        $coinSmall = config("trans.ordercoinsmall");

        $outAmount = $amount - $withdrawalRate * $amount;
        $fee = $withdrawalRate * $amount;

        //判断是否用最小手续费
        if ($fee < $coinSmall) {
            $fee = $coinSmall;
        }

        DB::beginTransaction();
        //代币余额 在途平掉 -= 提现数量 - 手续费 余额 -= 提现数量 - 手续费
        $sysCoin = new CoinData();
        $sysCoinRes = $sysCoin->saveCashPending($coinType, $outAmount, $date);
        if ($sysCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //系统代币流水 在途平掉 = -提现数量 - 手续费 支出 = 提现数量 - 手续费
        $sysCoinJournal = new JournalData();
        $sysJournalRes = $sysCoinJournal->addJournal($sysCoinJournalNo, $coinType, -$outAmount, $no, $sysCoinRes, 'CJ01', 'CJT02', 0, $outAmount, $date);
        if ($sysJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币账户 在途平掉 -= 提现数量 余额不变
        $userCoin = new UserCoinAccountData();
        $userCoinRes = $userCoin->savePendingShao($coinType, $amount, $userid, $date);
        if ($userCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途平掉 = -提现数量 - 手续费
        $userJournal = new CoinJournalData();
        $userCoinJournal['pending'] = $userCoinRes['pending'] + $fee;
        $userCoinJournal['cash'] = $userCoinRes['cash'] - $fee;
        $userCoinJournal['id'] = $userCoinRes['id'];
        $userJournalRes = $userJournal->addCoinJournal($userCoinJournal, $coinType, $userCoinJournalNo, -$outAmount, $no, 'CJT02', 'UOJ02', 0, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途平掉 = -手续费
        $userJournalRes = $userJournal->addCoinJournal($userCoinRes, $coinType, $userCoinJournalNo, -$fee, $no, 'CJT02', 'UOJ03', 0, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //系统代币账户 在途平掉 -= 手续费 余额增加 += 手续费
        $coinAccount = new CoinAccountData();
        $coinAccountRes = $coinAccount->savePendingCash($coinType, $fee, $date);
        if ($coinAccountRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //系统代币流水 在途平掉 = -手续费 收入 = 手续费
        $coinJournal = new SysCoinJournalData();
        $coinJournalRes = $coinJournal->addJournal($coinJournalNo, -$fee, $no, $coinAccountRes, $coinType, 'COJ01 ', 'OJT02', $fee, 0, $date);
        if ($coinJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //代币手续费表更新
        $coinFee = new FeeData();
        $feeRes = $coinFee->saveFee($no, 'CWF01', 1, $date);
        if ($feeRes === false) {
            DB::rollBack();
            return false;
        }

        //更新提现表
        $rechargeRes = $coinRecharge->saveWith($no, $outAmount, 'OW01', 1, $date);
        if ($rechargeRes === false) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * 提现失败
     *
     * @param   $no 单据号
     * @param   $sysCoinJournalNo 系统流水单据号
     * @param   $userCoinJournalNo 用户流水单据号
     * @param   $coinJournalNo 系统代币流水单据号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function FalseWithdrawal($no, $sysCoinJournalNo, $userCoinJournalNo, $coinJournalNo, $date)
    {
        //查询代币提现表数据
        $coinRecharge = new WithdrawalData();
        $coinRechargeInfo = $coinRecharge->getWithdrawal($no);
        $coinType = $coinRechargeInfo->coin_withdrawal_cointype;
        $amount = $coinRechargeInfo->coin_withdrawal_amount;
        $userid = $coinRechargeInfo->coin_withdrawal_userid;

        $withdrawalRate = config("trans.withdrawalcoinfeerate");

        $coinSmall = config("trans.ordercoinsmall");

        $outAmount = $amount - $withdrawalRate * $amount;
        $fee = $withdrawalRate * $amount;

        //判断是否用最小手续费
        if ($fee < $coinSmall) {
            $fee = $coinSmall;
        }

        DB::beginTransaction();
        //代币余额 在途平掉 -= 提现数量 - 手续费 余额不变
        $sysCoin = new CoinData();
        $sysCoinRes = $sysCoin->savePending($coinType, $outAmount, $date);
        if ($sysCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //系统代币流水 在途平掉 = -提现数量 - 手续费
        $sysCoinJournal = new JournalData();
        $sysJournalRes = $sysCoinJournal->addJournal($sysCoinJournalNo, $coinType, -$outAmount, $no, $sysCoinRes, 'CJ01', 'CJT03', 0, 0, $date);
        if ($sysJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币账户 在途平掉 -= 提现数量 余额增加 += 提现数量
        $userCoin = new UserCoinAccountData();
        $userCoinRes = $userCoin->saveUserCoinCash($coinType, $amount, $userid, $date);
        if ($userCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途平掉 = -提现数量 - 手续费 收入 = 提现数量 - 手续费
        $userJournal = new CoinJournalData();
        $userCoinJournal['pending'] = $userCoinRes['pending'] + $fee;
        $userCoinJournal['cash'] = $userCoinRes['cash'] - $fee;
        $userCoinJournal['id'] = $userCoinRes['id'];
        $userJournalRes = $userJournal->addCoinJournal($userCoinJournal, $coinType, $userCoinJournalNo, -$outAmount, $no, 'CJT03', 'UOJ02', $outAmount, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途平掉 = -手续费 收入 = 手续费
        $userJournalRes = $userJournal->addCoinJournal($userCoinRes, $coinType, $userCoinJournalNo, -$fee, $no, 'CJT03', 'UOJ03', $fee, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //系统代币账户 在途平掉 -= 手续费
        $coinAccount = new CoinAccountData();
        $coinAccountRes = $coinAccount->savePending($coinType, $fee, $date);
        if ($coinAccountRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //系统代币流水 在途平掉 = -手续费
        $coinJournal = new SysCoinJournalData();
        $coinJournalRes = $coinJournal->addJournal($coinJournalNo, -$fee, $no, $coinAccountRes, $coinType, 'COJ01 ', 'OJT03', 0, 0, $date);
        if ($coinJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //代币手续费表更新
        $coinFee = new FeeData();
        $feeRes = $coinFee->saveFee($no, 'CWF02', 0, $date);
        if ($feeRes === false) {
            DB::rollBack();
            return false;
        }

        //更新提现表
        $rechargeRes = $coinRecharge->saveWith($no, 0, 'OW02', 0, $date);
        if ($rechargeRes === false) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }
}
