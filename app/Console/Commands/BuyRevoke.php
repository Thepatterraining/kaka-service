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

class BuyRevoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:buyRevoke {no}';

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
     * @author zhoutao
     * @date   2017.8.22
     */
    public function handle(Session $session)
    {
        $buyNo = $this->argument('no');
        $buyData = new \App\Data\Trade\TranactionBuyData;
        $buy = $buyData->getByNo($buyNo);
        if (!empty($buy)) {
            $userid = $buy->buy_userid;
            $date = date('Y-m-d H:i:s');
            $session = resolve('App\Http\Utils\Session');
            $session->userid = $userid;
            $sellData = new \App\Data\Trade\RevokeBuyData;
            $sellData->revokeBuy($buyNo, $date);
        }
        

        $this->info('ok!');
    }
}
