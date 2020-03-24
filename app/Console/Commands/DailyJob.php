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


class DailyJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:daily';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MakeDaily Sheet';
    
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
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
      

        $this->info("Make Daily Jobs : {$start}->${end}");
        $scheduleItemData=new ScheduleItemData();
        $scheduleItemData->createDailyJob();
    }
}
