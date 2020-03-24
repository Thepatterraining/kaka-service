<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;
use App\Data\User\CoinAccountData;
use App\Data\User\CoinJournalData;
use App\Data\User\OrderData;
use App\Data\Activity\VoucherInfoData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\ItemData;
use App\Data\Sys\CashAccountData as SysCashAccountData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\Sys\CoinAccountData as SysCoinAccountData;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;

class OrderRevoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:orderRevoke {no}';

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
        $orderNo = $this->argument('no');
        $transactionOrderData = new TranactionOrderData();

        $orderInfo = $transactionOrderData->getByNo($orderNo);
        $count = $orderInfo->order_count; //获取要回滚的平米
        $buyFeePrice = $orderInfo->order_touser_showprice;
        $buyFeeCount = $orderInfo->order_touser_showcount;
        $buyFeeAmount = $buyFeePrice * $buyFeeCount; // 单价 * 份数 = 要回滚的钱
        $buyCash = $orderInfo->order_count * $orderInfo->order_price;
        $buyUserid = $orderInfo->order_buy_userid;
        $sellUserid = $orderInfo->order_sell_userid;
        $coinType = $orderInfo->order_coin_type;
        $buyCashFee = $orderInfo->order_buycash_fee;
        $buyCoinFee = $orderInfo->order_coin_fee;
        $sellCoinFee = $orderInfo->order_sellcoin_fee;
        $sellCash = $orderInfo->order_cash;
        $sellCashFee = $orderInfo->order_cash_fee;
        

        //查询这个代金券
        $cashOrderData = new OrderData;
        $voucherInfoData = new VoucherInfoData;
        $coupon = $cashOrderData->getCoupon($orderNo, OrderData::BUY_TYPE, $buyUserid);
        if ($coupon == '未使用') {
            $couponAmount = 0;
        } else {
            //查询代金券金额
            $couponInfo = $voucherInfoData->getByNo($coupon);
            $couponAmount = $couponInfo->voucher_val2;
        }

        $buyFeeAmount -= $couponAmount;


        $this->info('代金券号'.$coupon);
        $this->info('代金券金额'.$couponAmount);
        $this->info('买方用户id'.$buyUserid);
        $this->info('卖方用户id'.$sellUserid);
        //开始把平米回滚到卖方手里
        $coinAccountData = new CoinAccountData;
        $cashAccountData = new CashAccountData;
        $coinAccountData->revokeOrder($coinType, $orderNo, CoinJournalData::VOUCHER_STATUS, CoinJournalData::VOUCHER_TYPE, $count, $sellUserid);

        //收入代币手续费
        $coinAccountData->revokeOrder($coinType, $orderNo, CoinJournalData::VOUCHER_STATUS, CoinJournalData::VOUCHER_TYPE, $sellCoinFee, $sellUserid);

        //支出现金
        $cashAccountData->reduceCash($orderNo, $sellCash, $sellUserid, CashJournalData::TYPE_VOUCHER, CashJournalData::STATUS_VOUCHER);

        //收入现金手续费
        $cashAccountData->revokeOrder($orderNo, CashJournalData::TYPE_VOUCHER, CashJournalData::STATUS_VOUCHER, $sellCashFee, $sellUserid);

        //开始把钱回滚到买方手里
         //收入钱
        $cashAccountData->revokeOrder($orderNo, CashJournalData::TYPE_VOUCHER, CashJournalData::STATUS_VOUCHER, $buyCash, $buyUserid);

        //收入手续费
        $cashAccountData->revokeOrder($orderNo, CashJournalData::TYPE_VOUCHER, CashJournalData::STATUS_VOUCHER, $buyCashFee, $buyUserid);

        //支出现金券金额
        $cashAccountData->reduceCash($orderNo, $couponAmount, $buyUserid, CashJournalData::TYPE_VOUCHER, CashJournalData::STATUS_VOUCHER);
        
        //支出代币
        $coinAccountData->reduceCash($coinType, $orderNo, CoinJournalData::VOUCHER_STATUS, CoinJournalData::VOUCHER_TYPE, $count, $buyUserid);
        
        //收入代币手续费
        $coinAccountData->revokeOrder($coinType, $orderNo, CoinJournalData::VOUCHER_STATUS, CoinJournalData::VOUCHER_TYPE, $buyCoinFee, $buyUserid);
        
        //系统指出现金手续费
        $sysCashAccountData = new SysCashAccountData;
        $sysCashAccountData->reduceCash($orderNo, $sellCashFee, SysCashJournalData::VOUCHER_TYPE, SysCashJournalData::VOUCHER_STATUS);
        
        //买家手续费
        $sysCashAccountData->reduceCash($orderNo, $buyCashFee, SysCashJournalData::VOUCHER_TYPE, SysCashJournalData::VOUCHER_STATUS);

        //收入现金券金额
        $sysCashAccountData->increaseCash($orderNo, $couponAmount, SysCashJournalData::VOUCHER_TYPE, SysCashJournalData::VOUCHER_STATUS);
        
        //支出代币手续费
        $sysCoinAccountData = new SysCoinAccountData;
        $sysCoinAccountData->reduceCash($orderNo, $coinType, $sellCoinFee, SysCoinJournalData::VOUCHER_TYPE, SysCoinJournalData::VOUCHER_STATUS);

        //支出买家代币手续费
        $sysCoinAccountData->reduceCash($orderNo, $coinType, $buyCoinFee, SysCoinJournalData::VOUCHER_TYPE, SysCoinJournalData::VOUCHER_STATUS);
        
        if ($coupon != '未使用') {
            //补发一张代金券
            //查询活动
            $activityItemData = new ItemData;
            $activityNo = $activityItemData->getActivityNo($coupon, ItemData::COUPON_TYPE);

            $voucherData = new VoucherStorageData();
            $timespan = 7776000;
            $outtime = date('U') + $timespan;
            $voucherData->addStorage('', $coupon, $activityNo, $buyUserid, $outtime);
        }

        $this->info('ok!');
    }
}
