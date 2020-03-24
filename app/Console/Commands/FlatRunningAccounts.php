<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Sys\CashJournalData;
use App\Data\Sys\CashData;
use App\Data\Cash\BankAccountData;

class FlatRunningAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:flatCash {in} {out} {pending} {bankid}';

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

        
        //修改平台现金账户
        $userCashData = new CashData();
        $bankData = new BankAccountData();
        dump(1);
        if ($out > 0) {
            $usercashRes = $userCashData->savePendingCashTwo($pending, $out, null);
             //修改银行卡余额
            $bankData->saveNoTypePendingCash($sysBankid, $pending, $out);
        } elseif ($in > 0) {
            $usercashRes = $userCashData->savePendingCashTwo($pending, -$in, null);
            $bankData->saveNoTypePendingCash($sysBankid, $pending, -$in);
        } else {
            $usercashRes = $userCashData->savePendingCashTwo($pending, 0, null);
            $bankData->saveNoTypePendingCash($sysBankid, $pending, 0);
        }
        $date = null;

       

        //修改平台现金流水
        $userCashJournalData = new CashJournalData();
        $jobNo = $userCashJournalData->add(null, '', $pending, $usercashRes, CashJournalData::VOUCHER_TYPE, CashJournalData::VOUCHER_STATUS, $in, $out, $date, $sysBankid);
        $this->info('成功');
    }
}
