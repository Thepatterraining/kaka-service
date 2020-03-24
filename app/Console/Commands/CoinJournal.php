<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;
use App\Data\User\CoinAccountData;
use App\Data\User\CoinJournalData;
use App\Data\Activity\VoucherInfoData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\ItemData;
use App\Data\Sys\CashAccountData as SysCashAccountData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\Sys\CoinAccountData as SysCoinAccountData;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;

class CoinJournal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:coinJournal';

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
    public function handle(Session $session)
    {
        $data = new \App\Data\User\CoinJournalData;
        $userCoin['pending']  = 0;
        $userCoin['cash'] = 0;
        $userCoin['id'] = 379;
        $coinType = 'KKC-BJ0001';
        $userCoinJournalNo = '';
        $count = '4.064';
        $transactionSellNo = '';
        $type = 'UOJ11';
        $status = 'CJT08';
        $userid = 2;
        $date = date('Y-m-d H:i:s');
        $data->addCoinJournal($userCoin, $coinType, $userCoinJournalNo, 0, $transactionSellNo, $status, $type, 0, $count, $userid, $date);

        $coinType = 'KKC-BJ0002';
        $count = '24.158';
        $userCoin['id'] = 15;
        $data->addCoinJournal($userCoin, $coinType, $userCoinJournalNo, 0, $transactionSellNo, $status, $type, 0, $count, $userid, $date);
    }
}
