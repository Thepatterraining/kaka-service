<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Sys\CoinAccountData;
use App\Data\Sys\CoinData;
use App\Data\User\CoinJournalData;
use App\Data\Sys\UserData;
use App\Data\Utils\DocMD5Maker;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use Illuminate\Support\Facades\DB;
use App\Data\Sys\JobsLock;
use App\Data\User\UserVpData;

class CoinRechageData extends IDatafactory
{
    /**
     * 充值代币业务
     *
     * @param   $coinType 代币类型
     * @param   $userid 用户id
     * @param   $amount 充值数量
     * @param   $no 充值单据号
     * @param   $type 充值表类型
     * @param   $sysCoinJournalNo 系统流水单据号
     * @param   $userCoinJournalNo 用户流水单据号
     * @param   $date 日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function recharge($coinType, $userid, $amount, $no, $type, $sysCoinJournalNo, $userCoinJournalNo, $isPrimary, $date)
    {

        $lk = new JobsLock();

        //查找用户信息
        $user = new UserData();
        $userInfo = $user->getUser($userid);

        //创建钱包地址
        $addressData = new AddressData();
        $address = $addressData->createAddress($coinType, $userid, $userInfo->user_name, $userInfo->user_idno);
        $lk->lockUserCoin($coinType, $userid);

        //查询代币池里面有没有这个币种
        $sysCoin = new CoinData();
        $sysCoinInfo = $sysCoin->getCoin($coinType);
        if ($sysCoinInfo === null) {
            $sysCoinRes = $sysCoin->addCoin($coinType, $address);
            if ($sysCoinRes === false) {
                $lk->unlockUserCoin($coinType, $userid);
                return false;
            }
        }

        //查询系统里面有没有这个币种
        $sysCoinAccount = new CoinAccountData();
        $sysCoinInfo = $sysCoinAccount->getCoin($coinType);
        if ($sysCoinInfo === null) {
            $sysCoinRes = $sysCoinAccount->addCoin($coinType, $address);
            if ($sysCoinRes === false) {
                $lk->unlockUserCoin($coinType, $userid);
                return false;
            }
        }

        DB::beginTransaction();

        //查询用户有没有这个币种
        $userCoin = new UserCoinAccountData();
        if ($isPrimary === true) {
            //一级发币 查一级有没有，没有就增加
            $userCoinInfo = $userCoin->GetCoin($userid, $coinType);
            //查普通有没有，如果有普通，那么拒绝发币
            $CoinInf = $userCoin->getUserCoin($coinType, $userid);
            if ($CoinInf !== null && $CoinInf->usercoint_isprimary == false) {
                $lk->unlockUserCoin($coinType, $userid);
                return false;
            }

            //查询vp有没有，没有的话增加vp
            $userVpData = new UserVpData();
            $userVpInfo = $userVpData->getUserWhereCoinType($userid, $coinType);
            if (empty($userVpInfo)) {
                //增加vp用户
                $userVpData->add($userid, $coinType);
            } else {
                //如果是无效用户，更新成有效
                if (!$userVpInfo->enable) {
                    $userVpData->saveEnable($userid, $coinType);
                }
            }
        } else {
            //普通发币，查询普通有没有，没有就增加账户
            $userCoinInfo = $userCoin->getUserCoin($coinType, $userid);
            //查询如果一级有代币，那么拒绝发币
            if ($userCoinInfo !== null && $userCoinInfo->usercoint_isprimary == true) {
                $lk->unlockUserCoin($coinType, $userid);
                return false;
            }
        }
        if ($userCoinInfo == null) {
            $userCoinRes = $userCoin->addUserCoin($coinType, $userid, $isPrimary);
            if ($userCoinRes === false) {
                $lk->unlockUserCoin($coinType, $userid);
                return false;
            }
        }

        //        //查询有没有这个项目
        //        $itemData = new ItemData();
        //        $itemInfo = $itemData->getItem($coinType);
        //        if ($itemInfo == null) {
        //            //添加项目
        //            $itemRes = $itemData->addItem('test',$coinType,'朝阳太阳宫','咔咔一号');
        //            if ($itemRes === false) {
        //                DB::rollBack();
        //                $lk->unlockUserCoin($coinType,$userid);
        //                return false;
        //            }
        //        }

        
        //代币充值表添加数据
        $coinRecharge = new RechageData();
        $coinRechargeRes = $coinRecharge->addRecharge($no, $coinType, $amount, $userid, $address, $type, 'OR00', $date);
        if ($coinRechargeRes === false) {
            DB::rollBack();
            $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //系统代币余额 在途增加 += 充值数量
        $sysCoinRes = $sysCoin->saveCoin($coinType, $amount, $date);
        if ($sysCoinRes['res'] === false) {
            DB::rollBack();
            $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //系统代币流水 在途增加 = 充值数量
        $sysCoinJournal = new JournalData();
        $sysJournalRes = $sysCoinJournal->addJournal($sysCoinJournalNo, $coinType, $amount, $no, $sysCoinRes, 'CJ02', 'CJT01', 0, 0, $date);
        if ($sysJournalRes === false) {
            DB::rollBack();
            $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //用户代币账户 在途增加 += 充值数量
        $userCoinRes = $userCoin->savePending($userid, $coinType, $amount, $isPrimary, $date);
        if ($userCoinRes['res'] === false) {
            DB::rollBack();
            $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //用户代币流水 在途增加 = 充值数量
        $userJournal = new CoinJournalData();
        $userJournalRes = $userJournal->addCoinJournal($userCoinRes, $coinType, $userCoinJournalNo, $amount, $no, 'CJT01', 'UOJ01', 0, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        DB::commit();
           $lk->unlockUserCoin($coinType, $userid);
        return true;
    }

    /**
     * 审核成功
     *
     * @param   $no 单据号
     * @param   $sysCoinJournalNo 系统流水单据号
     * @param   $userCoinJournalNo 用户流水单据号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function TrueRecharge($no, $sysCoinJournalNo, $userCoinJournalNo, $date)
    {
        $lk = new JobsLock();
        //查询代币充值表数据
        $coinRecharge = new RechageData();
        $coinRechargeInfo = $coinRecharge->getRecharge($no);
        $coinType = $coinRechargeInfo->coin_recharge_cointype;
        $amount = $coinRechargeInfo->coin_recharge_amount;
        $userid = $coinRechargeInfo->coin_recharge_userid;
        //dump($amount);
        $lk->lockUserCoin($coinType, $userid);
        DB::beginTransaction();
        //系统代币余额 在途平掉 -= 充值数量 余额 += 充值数量
        $sysCoin = new CoinData();
        $sysCoinRes = $sysCoin->savePendingCash($coinType, $amount, $date);
        if ($sysCoinRes['res'] === false) {
            DB::rollBack();
                       $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //系统代币流水 在途平掉 = -充值数量 收入 = 充值数量
        $sysCoinJournal = new JournalData();
        $sysJournalRes = $sysCoinJournal->addJournal($sysCoinJournalNo, $coinType, -$amount, $no, $sysCoinRes, 'CJ02', 'CJT02', $amount, 0, $date);
        if ($sysJournalRes === false) {
            DB::rollBack();
                       $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //用户代币账户 在途平掉 -= 充值数量 余额 += 充值数量
        $userCoin = new UserCoinAccountData();
        $userCoinRes = $userCoin->saveUserCoinCash($coinType, $amount, $userid, $date);
        if ($userCoinRes['res'] === false) {
            DB::rollBack();
                       $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //用户代币流水 在途增加 = 充值数量 收入 = 充值数量
        $userJournal = new CoinJournalData();
        $userJournalRes = $userJournal->addCoinJournal($userCoinRes, $coinType, $userCoinJournalNo, -$amount, $no, 'CJT02', 'UOJ01', $amount, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
                       $lk->unlockUserCoin($coinType, $userid);
            return false;
        }

        //更新充值表
        $rechargeRes = $coinRecharge->saveRecharge($no, 'OR01', 1, $date);
        if ($rechargeRes === false) {
            DB::rollBack();
            
            return false;
        }

        DB::commit();
            $lk->unlockUserCoin($coinType, $userid);
        return true;
    }

    /**
     * 充值失败
     *
     * @param   $no 单据号
     * @param   $sysCoinJournalNo 系统流水单据号
     * @param   $userCoinJournalNo 用户流水单据号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function FalseRecharge($no, $sysCoinJournalNo, $userCoinJournalNo, $date)
    {
        //查询代币充值表数据
        $coinRecharge = new RechageData();
        $coinRechargeInfo = $coinRecharge->getRecharge($no);
        $coinType = $coinRechargeInfo->coin_recharge_cointype;
        $amount = $coinRechargeInfo->coin_recharge_amount;
        $userid = $coinRechargeInfo->coin_recharge_userid;

        DB::beginTransaction();
        //系统代币余额 在途平掉 -= 充值数量 余额不变
        $sysCoin = new CoinData();
        $sysCoinRes = $sysCoin->savePending($coinType, $amount, $date);
        if ($sysCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //系统代币流水 在途平掉 = -充值数量
        $sysCoinJournal = new JournalData();
        $sysJournalRes = $sysCoinJournal->addJournal($sysCoinJournalNo, $coinType, -$amount, $no, $sysCoinRes, 'CJ01', 'CJT03', 0, 0, $date);
        if ($sysJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //用户代币账户 在途平掉 -= 充值数量 余额不变
        $userCoin = new UserCoinAccountData();
        $userCoinRes = $userCoin->savePendingShao($coinType, $amount, $userid, $date);
        if ($userCoinRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //用户代币流水 在途增加 = 充值数量
        $userJournal = new CoinJournalData();
        $userJournalRes = $userJournal->addCoinJournal($userCoinRes, $coinType, $userCoinJournalNo, -$amount, $no, 'CJT03', 'UOJ01', 0, 0, $userid, $date);
        if ($userJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //更新充值表
        $rechargeRes = $coinRecharge->saveRecharge($no, 'OR02', 0, $date);
        if ($rechargeRes === false) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }
}
