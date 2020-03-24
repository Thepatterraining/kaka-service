<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Sys\CoinAccountData;
use App\Data\Sys\CoinJournalData;

class SystemRunningCoinAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:sysCoin {coin} {in} {out} {pending}';

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
        $coinType  = $this->argument('coin');

        
        //修改系统代币账户
        $userCashData = new CoinAccountData();
        if ($out > 0) {
            $usercashRes = $userCashData->saveCashPending($coinType, $pending, $out);
        } elseif ($in > 0) {
            $usercashRes = $userCashData->saveCashPending($coinType, $pending, -$in);
        } else {
            $usercashRes = $userCashData->saveCashPending($coinType, $pending, 0);
        }
        $date = null;
        //修改系统代币流水
        $userCashJournalData = new CoinJournalData();
        $jobNo = $userCashJournalData->addJournal(null, $pending, '', $usercashRes, $coinType, CoinJournalData::VOUCHER_TYPE, CoinJournalData::VOUCHER_STATUS, $in, $out, $date);

        $this->info('成功');
    }
}
