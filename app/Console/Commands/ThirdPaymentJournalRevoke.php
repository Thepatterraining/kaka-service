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
use Illuminate\Support\Facades\DB;
use App\Data\Cash\BankAccountData;


class ThirdPaymentJournalRevoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:thirdpayjournalrevoke';
    
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
     * 平掉第三方充值的备付金流水
     *
     * @return mixed
     * @author zhoutao
     * @date   17.8.11
     */
    public function handle()
    {
        $sysCashJournalData = new \App\Data\Sys\CashJournalData;
        $journals = DB::select(
            "select count(*) as count,max(id) as id ,`syscash_journal_jobno`,
                    `syscash_journal_pending`,`syscash_journal_out` 
                    from `sys_cash_journal` 
                    where `syscash_journal_jobno` like 'CR%' 
                    and `syscash_journal_pending` > 0 
                    and `syscash_journal_out` > 0 
                    group by `syscash_journal_jobno`,
                    `syscash_journal_pending`,`syscash_journal_out`"
        );
        if (count($journals) > 0) {
            $i = 0;
            foreach ($journals as $journal) {
                if ($journal->count == 2) {
                    $id = $journal->id;
                    $info = $sysCashJournalData->get($id);
                    $date = $info->syscash_journal_datetime;
                    $pending = $info->syscash_journal_pending;
                    $in = $info->syscash_journal_out;
                    $jobNo = $info->syscash_journal_jobno;
                    $type = $info->syscash_journal_type;
                    $status = $info->syscash_journal_status;
                    $account = $info->syscash_jounal_account;
                    if ($account != '') {
                        $this->info($i++);
                        $sysCashJournalData->ThirdPartyRechargeFalse($jobNo, $account, $pending, $type, $status, $in, 0, $date, BankAccountData::TYPE_STOCK_FUND);
                    }
                    
                } 
            }
            $this->info('ok');
        }
    }
}
