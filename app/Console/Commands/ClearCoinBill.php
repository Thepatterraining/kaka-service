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
use App\Data\Sys\ClearData;
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
        $cashList = $model->where('usercash_journal_type', CashJournalData::CLEAR_TYPE)->get();

        $coinJourData = new CoinJournalData;
        $coinJourModel = $coinJourData->newitem();
        $coinList = $coinJourModel->where('usercoin_journal_type', CashJournalData::CLEAR_TYPE)->get();

        $data = new CashOrderData;
        $clearData = new ClearData;
        $price = '49866.71';
        $clearPrice = bcmul(strval($price), strval('0.01'), 2);
        foreach($cashList as $cashJ) {
            // foreach($coinList as $coinJ) {
                
            // }
            if ($cashJ->usercash_journal_in > 0) {
                $count = bcdiv(strval($cashJ->usercash_journal_in), strval($price), 2);
                $no = $clearData->add($cashJ->usercash_journal_userid, $clearPrice, $count, 'KKC-BJ0003');
                $data->add($no, $cashJ->usercash_journal_in,CashOrderData::USER_CLEAR_TYPE,$cashJ->usercash_result_cash, $cashJ->usercash_journal_userid);
            }
            
        }

        $this->info('结算成功');
    }
}
