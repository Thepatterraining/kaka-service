<?php
namespace App\Data\Voucher;

use App\Data\Voucher\IUsingVoucher;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\VoucherInfoData;

class UsingVoucherSpecial implements IUsingVoucher
{


    /**
     * 返回用户是否可以使用该券
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.13
     * @param   $storageNo -- 用户持有现金券号 
     * @param   $docInfo 
     * @param   $userid -- 用户id
     **/
    public function canUsingVoucher($storageNo,$docInfo,$userid)
    {
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

        if ($docInfo->sell_cointype === $voucherInfo->voucher_note) {
            return true;
        }
        return false;
    }

    /**
     * 返回用户是否可以使用该券 在下单前调用
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.13
     * @param   $storageNo -- 用户持有现金券号 
     * @param   $totalMoney 总金额
     * @param   $userid -- 用户id
     **/
    public function CanUsingVoucherBuy($storageNo,$totalMoney,$userid)
    {
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

        $val1 = $voucherInfo->voucher_val1;
        if (bccomp(strval($totalMoney), strval($val1), 2) === 1) {
            return true;
        }
        return false;
    }
}
