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
use App\Http\Utils\RaiseEvent;

class MinutelyJob extends Command
{
    use RaiseEvent;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:minutely';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Minutely DataSheet';

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

        $end = date("Y-m-d H:m:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-5 minutes"));
        $scheduleItemData=new ScheduleItemData();
        $scheduleItemData->createMinutelyJob();

        $this->RaisEvent();
        $this->RaisQueueEvent();

    }
}
