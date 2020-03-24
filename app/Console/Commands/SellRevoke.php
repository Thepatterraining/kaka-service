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

class SellRevoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:sellRevoke {no}';

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
        $sellNo = $this->argument('no');
        $date = date('Y-m-d H:i:s');
        $sellData = new \App\Data\Trade\CoinSellData;
        $sellData->revokeSell($sellNo, $date);

        $this->info('ok!');
    }
}
