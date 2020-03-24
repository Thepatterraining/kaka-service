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

class ClearCoinType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:clearCoinType {coinType} {price}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清算代币';

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
        $coinType = $this->argument('coinType');
        $price = $this->argument('price');

        $data = new CoinAccountData;
        $data->clearCoin($coinType, $price);

        $this->info('代币类型：'. $coinType);
        $this->info('结算单价：'. $price);
        $this->info('结算成功');
    }
}
