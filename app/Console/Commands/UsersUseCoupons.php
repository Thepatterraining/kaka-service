<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;
use App\Data\User\OrderData;

class UsersUseCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:useCoupons {userid} {orderNo} {voucherNo} {sysBank}';

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

        $sysBankid = $this->argument('sysBank');
        $tranactionOrderNo = $this->argument('orderNo');
        $buyId = $this->argument('userid');
        $voucherNo = $this->argument('voucherNo');
        $session->userid = $buyId;

        $orderData = new TranactionOrderData();
        $orderInfo = $orderData->getByNo($tranactionOrderNo);
        $amount = $orderInfo->order_amount;
        $cointype = $orderInfo->order_coin_type;
        $count = $orderInfo->order_count;

        $date = date('Y-m-d H:i:s');
        $voucherNo = $orderData->voucher($buyId, '', $tranactionOrderNo, '', $voucherNo, $amount, $cointype, $count, $date, '7776000', $sysBankid, 1);

        $orderData = new OrderData();
        $orderData->saveCoupons($tranactionOrderNo, $voucherNo);
        $this->info('运行完成');
    }
}
