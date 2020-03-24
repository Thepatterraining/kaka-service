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
use App\Data\Report\ReportSettlementDayListData;


class DayJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:day {start} {end}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make History Day Sheet';
    
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
        $reportSettlementDayListData=new ReportSettlementDayListData();
        $startDate = $this->argument('start');
        $endDate = $this->argument('end');
        $start=date_create($startDate);
        $end=date_create($endDate);
        $tmp_start=date_create($startDate);
        $tmp_end=date_create($startDate);
        date_add($tmp_end, date_interval_create_from_date_string("1 day"));
        dump($end);

        while($tmp_start!=$end)
        {
            dump($tmp_start);
            $tmpstartdate=date_format($tmp_start, "Y-m-d");
            $tmpenddate=date_format($tmp_end, "Y-m-d");
            $this->info("Make Daily Jobs : {$tmpstartdate}->${tmpenddate}");
            $items=$reportSettlementDayListData->historyrun($tmp_start, $tmp_end, $tmpstartdate);
            date_add($tmp_start, date_interval_create_from_date_string("1 day"));
            date_add($tmp_end, date_interval_create_from_date_string("1 day"));
        }
        dump('all complete'); 
        return true;
    }
}
