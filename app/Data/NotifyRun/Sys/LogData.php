<?php
namespace App\Data\NotifyRun\Sys;
use App\Data\Notify\INotifyData;
use App\Data\Report\ReportWithdrawalDayData;
use App\Data\Notify\INotifyDefault;
use App\Data\IDataFactory;

class LogData extends IDatafactory implements INotifyDefault
{
    //
    public function notifyrun($data)
    {
        $notifyData=new INotifyData();
        $event='NY07';
        $notifyData->doJob($event, $data["dumpinfo"], null, $data["created_at"]);
        return true;
    }
}