<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\CoinAccountData;
use App\Data\User\CoinJournalData;

class UserCoinLedger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:userCoin {user} {in} {out}  {coin} {--pending=}';

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
        $userid = $this->argument('user');
        $in = $this->argument('in');
        $out = $this->argument('out');
        $pending = $this->option('pending');
        $coinType  = $this->argument('coin');

        
        //修改用户代币账户
        $userCashData = new CoinAccountData();
        if ($out > 0) {
            $usercashRes = $userCashData->savePendingCash($coinType, $out, $pending, $userid);
        } elseif ($in > 0) {
            $usercashRes = $userCashData->savePendingCash($coinType, -$in, $pending, $userid);
        } else {
            $usercashRes = $userCashData->savePendingCash($coinType, 0, $pending, $userid);
        }
        $date = null;
        //修改用户代币流水
        $userCashJournalData = new CoinJournalData();
        $jobNo = $userCashJournalData->addCoinJournal($usercashRes, $coinType, '', $pending, '', CoinJournalData::VOUCHER_STATUS, CoinJournalData::VOUCHER_TYPE, $in, $out, $userid, $date);

        $this->info('成功');
    }
}
