<?php
namespace App\Data\Voucher;

use App\Data\Voucher\IUsedVoucher;
use App\Data\User\CashAccountData as UserCashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use App\Data\Sys\CashAccountData as SysCashAccountData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\Cash\BankAccountData;
use App\Data\User\UserTypeData;
use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;

class UsedVoucher implements IUsedVoucher
{


    /**
     * 用券后调用
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.13
     * @param   $storageNo -- 用户持有现金券号 
     * @param   $docInfo 
     * @param   $userid -- 用户id
     **/
    public function UsedVoucher($storageNo,$docInfo,$userid)
    {
        $date = date('Y-m-d');
        $storageData = new VoucherStorageData;
        $storageInfo = $storageData->getStorageInfo($storageNo);
        if (empty($storageInfo)) {
            return false;
        }

        $voucherData = new VoucherInfoData;
        $voucherInfo = $voucherData->getByNo($storageInfo->vaucherstorage_voucherno);

        if (empty($voucherInfo)) {
            return false;
        }

        $voucherNo = $voucherInfo->vaucher_no;
        $val2 = $voucherInfo->voucher_val2;

        //买方用户余额 余额 += 现金券金额
        $cashAccountData = new UserCashAccountData();
        $cashAccountData->increaseCash($docInfo->order_no, $val2, UserCashJournalData::TRANSACTION_ORDER_COUPONS_TYPE, UserCashJournalData::ORDER_STATUS, $userid, $date);

        //平台现金余额 余额 -= 现金券金额
        $cashBankAccountData = new BankAccountData;
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($userid);
        $bankCard = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];
        $cashBankAccountData->reduceCash(BankAccountData::TYPE_ESCROW, $docInfo->order_no, $val2, SysCashJournalData::COUPONS_TYPE, SysCashJournalData::COUPONS_STATUS, $date, $bankCard);

        //更新用户现金券 变成已使用
        $storageRes = $storageData->saveVoucherStorageStatus(VoucherStorageData::USE_STATUS, $storageNo, $docInfo->order_no, $date);

        //更新该现金券使用数量 使用数量 += 1
        $voucherData->saveUseCount($voucherNo);
    }
}