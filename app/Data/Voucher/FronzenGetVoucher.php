<?php
namespace App\Data\Voucher;

use App\Data\Voucher\IVoucher ;
use App\Data\Activity\VoucherStorageData;
use App\Data\Coin\FrozenData;
use App\Data\Activity\VoucherInfoData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\User\CoinJournalData as UserCoinJournalData;

class FronzenGetVoucher extends GettedVoucher
{


    protected function voucherGetted($voucherNo, $storageNo, $userid)
    {
        //查询
        $voucherData = new VoucherInfoData;
        $voucher = $voucherData->getByNo($voucherNo);
        $freezetime = $voucher->voucher_locktime;

        //冻结资产
        $count = 1;
        $coinType = 'KKC-BJ0001';
        $date = date('Y-m-d');

        $accountData = new UserCoinAccountData();
        $accountid = $accountData->getAccountid($coinType, $userid);

        //写入冻结表
        $data = new FrozenData();
        $frozenNo = $data->add($coinType, $accountid, $userid, '', $freezetime, $this->frozenType);

        //用户代币表 因为冻结，在途增加 += 冻结个数 余额 -= 冻结个数
        $accountRes = $accountData->reduceCashIncreasePending($coinType, $frozenNo, $count, $count, $userid, UserCoinJournalData::FROZEN_TYPE, UserCoinJournalData::FROZEN_STATUS, $date);
        return true;
    }
}