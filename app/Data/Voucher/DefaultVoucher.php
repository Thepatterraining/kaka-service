<?php
namespace App\Data\Voucher;

use App\Data\Voucher\IVoucher ;
use App\Data\User\CashAccountData as UserCashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use App\Data\Sys\CashAccountData as SysCashAccountData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Coin\FrozenData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Activity\VoucherInfoData;
use App\Data\Cash\BankAccountData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\Frozen\FrozenFactory;
use App\Data\User\UserTypeData;

class DefaultVoucher implements IVoucher
{

    private $voucherInfo;
    private $storageInfo;

    /**
     * 加载数据
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0
     * @date    Sep 6th,2017
     * @param   voucherinfo -- voucher的model 
     * @param   storageinf -- storage的model
     **/
    public function load_data($voucherInfo,$storageInfo)
    {
        $this->voucherInfo = $voucherInfo;
        $this->storageInfo = $storageInfo;
    }

    /**
     * 检查某个代币是否可以使用
     *
     * @author  geyunfie@kakamf.com
     * @version 1.0
     * @date    Sep,6th,2017;
     * @return 
     * true 可用
     * false 不可用
     **/
    public function CheckByCoinType($price,$coinType)
    {
        if (empty($this->voucherInfo)) {
            return false;
        }

        $val1 = $this->voucherInfo->voucher_val1;
        if (bccomp(strval($price), strval($val1), 2) === 1) {
            return true;
        }
        return false;
    }

    /**
     * 检查某个产品是否可以使用 
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0 
     * @date    Sep 6th,2017
     * @return 
     * true 可用
     * false 不可用
     */
    public function CheckByProduct($price,$productNo)
    {
        if (empty($this->voucherInfo)) {
            return false;
        }

        $val1 = $this->voucherInfo->voucher_val1;
        if (bccomp(strval($price), strval($val1), 2) === 1) {
            return true;
        }
        return false;
    }


    /**
     * 返回券的使用说明
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0
     * @date    Sep 6th,2017
     * @return  String 
     * ex. 满 100减 50；
     **/
    public function GetNotes()
    {
        if (empty($this->voucherInfo)) {
            return false;
        }

        $val1 = $this->voucherInfo->voucher_val1;
        $val2 = $this->voucherInfo->voucher_val2;
        $str = '满' . $val1 . '减' . $val2;
        return $str;
    }

    /**
     * 对某笔交易用券
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0
     * @date    Sep 6th,2017
     * @return 
     * true 成功
     * false 失败
     */
    public function ApplyVoucheToOrder($orderNo, $date, $freezetime = 0)
    {
        if (empty($this->voucherInfo) || empty($this->storageInfo)) {
            return '';
        }
        
        if ($this->storageInfo->voucherstorage_status != VoucherStorageData::UN_USE_STATUS) {
            return '';
        }

        if ($this->voucherInfo->voucher_count <= $this->voucherInfo->voucher_usecount) {
            return '';
        }

        //查询交易
        $orderData = new TranactionOrderData;
        $order = $orderData->getByNo($orderNo);
        if (empty($order)) {
            return '';
        }

        $voucherNo = $this->voucherInfo->vaucher_no;
        $val1 = $this->voucherInfo->voucher_val1;
        $val2 = $this->voucherInfo->voucher_val2;
        $amount = $order->order_amount;
        $buyCashFee = $order->order_buycash_fee;
        $buyUserid = $order->order_buy_userid;
        $count = $order->order_count;
        $coinType = $order->order_coin_type;

        if (bccomp(strval(bcadd(strval($amount), strval($buyCashFee), 3)), strval($val1), 3) === -1) {
            return '';
        }

        //买方用户余额 余额 += 现金券金额
        $cashAccountData = new UserCashAccountData();
        $cashAccountData->increaseCash($orderNo, $val2, UserCashJournalData::TRANSACTION_ORDER_COUPONS_TYPE, UserCashJournalData::ORDER_STATUS, $buyUserid, $date);

        //平台现金余额 余额 -= 现金券金额
        $cashBankAccountData = new BankAccountData;
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($buyUserid);
        $bankCard = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];
        $cashBankAccountData->reduceCash(BankAccountData::TYPE_ESCROW, $orderNo, $val2, SysCashJournalData::COUPONS_TYPE, SysCashJournalData::COUPONS_STATUS, $date, $bankCard);

        //更新用户现金券 变成已使用
        $storageData = new VoucherStorageData();
        $storageRes = $storageData->saveVoucherStorageStatus(VoucherStorageData::USE_STATUS, $this->storageInfo->vaucherstorage_no, $orderNo, $date);

        //更新该现金券使用数量 使用数量 += 1
        $voucherInfoData = new VoucherInfoData;
        $voucherInfoData->saveUseCount($voucherNo);

        //更新买方用户代币账户锁定时间
        $locktime = empty($freezetime) ? $this->voucherInfo->voucher_locktime : $freezetime;
        $locktime = date('U') + $locktime;
        $locktime = date('Y-m-d H:i:s', $locktime);
        $userCoinAccountData = new UserCoinAccountData();
        $userCoinAccountData->saveLockTIme($coinType, $buyUserid, $locktime);

        //冻结
        $frozenFac = new FrozenFactory;
        $orderFrozenData = $frozenFac->CreateFrozen(FrozenData::COUPONS_TYPE);
        $orderFrozen = $orderFrozenData->orderFrozen($orderNo, $date, $locktime);

        return $voucherNo;
    }
}