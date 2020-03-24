<?php
namespace App\Data\NotifyRun\Voucher;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Voucher\VoucherFactory;
use App\Data\Notify\INotifyDefault;
use App\Data\Activity\VoucherStorageData as StorageData;
use App\Data\Activity\VoucherInfoData;

class VoucherStorageData extends IDatafactory implements INotifyDefault
{
        
    /**
     * 收回项目后发卷
     *
     * @param  $data
     * @author zhoutao
     * @date   2017.11.11
     */
    public function notifyrun($data)
    {
        $voucherData = new StorageData();
        $voucherInfoData = new VoucherInfoData();

        $userid = $data['lending_lenduser'];
        $voucherNo = $data['params']['voucherNo'];
        $voucherInfo = $voucherInfoData->getByNo($voucherNo);
        if (!empty($voucherInfo)) {
            $timespan = $voucherInfo->voucher_timespan;
            $outtime = date('U') + $timespan;
            $voucherData->addStorage('', $voucherNo, '', $userid, $outtime);
        }

        //通知用户
        $this->AddEvent(StorageData::VOUCHER_EVENT_TYPE, $userid, $voucherNo);
    }
}