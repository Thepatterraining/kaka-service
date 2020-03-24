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

class GettedVoucher implements IGettedVoucher
{


    /**
     * 返回用户得到券后的操作
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.12
     * @param   $voucherNo -- 代金券号 
     * @param   $storageInfo storage 的info
     * @param   $userid -- 用户id
     **/
    public function gettedVoucher($voucherNo, $storageInfo, $userid)
    {
        //通知用户
        $this->AddEvent("Voucher_Check", $userid, $voucherNo);

        $this->voucherGetted($voucherNo, $storageInfo->no, $userid);
    }

    protected function voucherGetted($voucherNo, $storageNo, $userid)
    {
    }
}