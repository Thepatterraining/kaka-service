<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Report;
use Illuminate\Support\Facades\Storage;
use App\Data\User\UserData;
use App\Http\Adapter\AdapterFac;
use App\Data\Settlement\UserCashSettlementData;
use App\Data\Settlement\SysCashSettlementData;
use App\Data\Sys\LogData;
use App\Data\Cash\UserRechargeData;
use App\Data\Report\ReportSumsDayData;
use App\Data\Monitor\DebugInfoData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\User\UserRebateRankdayData;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Schedule\ScheduleItemData;
use App\Data\Report\ReportSettlementMonthListData;
use App\Data\Excel\ISettlementData;
use App\Mail\NotifyReport;

class MonthJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:month';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MakeMonth Sheet';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 得到开始时间和结束时间
        $reportSettlementMonthListData=new ReportSettlementMonthListData();
        $month=date("m");
        $date=date("Y-".$month."-1");
        $start=date_create($date);
        $end=date_create($date);
        $tmp_start=date_create($date);
        $tmp_end=date_create($date);
        $tmp_date=date("Y-m-1", strtotime("-1 month"));
        date_add($start, date_interval_create_from_date_string("-1 month"));
        // date_add($start, date_interval_create_from_date_string("5 days"));
        date_add($tmp_start, date_interval_create_from_date_string("-1 month"));
        // date_add($tmp_start, date_interval_create_from_date_string("5 days"));
        date_add($tmp_end, date_interval_create_from_date_string("-1 month"));
        date_add($tmp_end, date_interval_create_from_date_string("1 day"));
        // date_add($end, date_interval_create_from_date_string("-3 month"));
        dump($end);
        // while($end!=date_create($date))
        // {
            $items=array();
            // date_add($end, date_interval_create_from_date_string("1 month"));
        while($tmp_start!=$end)
            {
            dump($tmp_start);
            $startdate=date_format($tmp_start, "Y-m-d");
            $enddate=date_format($tmp_end, "Y-m-d");
            $this->info("Make Daily Jobs : {$startdate}->${enddate}");
            $scheduleItemData=new ScheduleItemData();
            $items[]=$reportSettlementMonthListData->historyrun($tmp_start, $tmp_end, $tmp_date);
            date_add($tmp_start, date_interval_create_from_date_string("1 day"));
            date_add($tmp_end, date_interval_create_from_date_string("1 day"));
            $tmp_date=date_format($tmp_start, "Y-m-d");
        }
            $docno=$date."汇总";
            $fileName ="/tmp/".$docno.".xlsx";
            $iSettlementData=new ISettlementData();
            $iSettlementData->arraySaveToExcel($items, null, $fileName, $start, $end, "ES01");
    
            $address="sunhongshi@kakamf.com";
            $name="孙宏拾";
            Mail::to([$address])->send(new NotifyReport($address, $name, "月汇总", $fileName));
        // }
        dump('complete'); 
        return true;
    }
}
