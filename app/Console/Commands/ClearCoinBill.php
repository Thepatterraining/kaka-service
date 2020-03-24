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
use App\Data\User\CashOrderData;

class ClearCoinBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:clearCoinBill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清算代币补账单';

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
        //查询用户流水
        $cashJourData = new CashJournalData;
        $model = $cashJourData->newitem();
        $list = $model->where('usercash_journal_type', CashJournalData::CLEAR_TYPE)->get();


        $data = new CashOrderData;

        foreach($list as $cashJ) {
            $this->info('金额：'.$cashJ->usercash_journal_in);
            $this->info('余额：'.$cashJ->usercash_result_cash);
            $data->add('', $cashJ->usercash_journal_in,$type,$cashJ->usercash_result_cash, $cashJ->usercash_journal_userid);
        }

        $this->info('结算成功');
    }
}
