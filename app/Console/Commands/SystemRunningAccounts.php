<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Sys\CashAccountData;
use App\Data\Sys\CashJournalData;
use App\Data\Cash\JournalData;

class SystemRunningAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:sysCash {in} {out} {pending} {bankid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $in = $this->argument('in');
        $out = $this->argument('out');
        $pending = $this->argument('pending');
        $sysBankid  = $this->argument('bankid');

        
        //修改系统现金账户
        $userCashData = new CashAccountData();
        if ($out > 0) {
            $usercashRes = $userCashData->saveCashPendingTwo($pending, $out, null);
        } elseif ($in > 0) {
            $usercashRes = $userCashData->saveCashPendingTwo($pending, -$in, null);
        } else {
            $usercashRes = $userCashData->saveCashPendingTwo($pending, 0, null);
        }
        $date = null;
        //修改系统现金流水
        $userCashJournalData = new JournalData();
        $jobNo = $userCashJournalData->add('', $sysBankid, $usercashRes, $pending, JournalData::VOUCHER_TYPE, JournalData::VOUCHER_STATUS, $in, $out, $date);

        $this->info('成功');
    }
}
