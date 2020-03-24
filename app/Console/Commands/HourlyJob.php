<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Cash\UserRechargeData;
use App\Data\Cash\SysRechargeData;
use App\Data\Settlement\UserCashSettlementData;
use App\Data\Settlement\CashSettlementData;
use App\Data\Settlement\SysCashSettlementData;
use App\Data\Report\ReportSumsHourData;
use App\Data\Schedule\ScheduleItemData;

class HourlyJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Hourly DataSheet';

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
        //

        $end = date("Y-m-d H:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 hours"));
        //     $this->info ("Make All User Settlement");

        //     $fac = new UserCashSettlementData();

        // //    $item = $fac->makeAllUserHourSettlement();
        //     $this->info("Make Sys Cash Settlement");

        //     $fac = new CashSettlementData();

        //    // $item = $fac->makeHourSettlement(1);

        //     $this->info("Make Palform Cash Settlement");



        //     $fac = new SysCashSettlementData();
        //     $userSumsReport=new ReportSumsHourData();
        //     $this->info("Make User Report");
        //     $userSumsReport->makeAllUserHourReport();
        //    // $item = $fac->makeHourSettlement(1);
        

        //     $this->info ('Refuse All User Recharge Data');
        //     $sysRecharge = new SysRechargeData;
        //     $sysRecharge->DealTimeoutThirdRechargeData();
        $scheduleItemData=new ScheduleItemData();
        $scheduleItemData->createHourlyJob();

    }
}
