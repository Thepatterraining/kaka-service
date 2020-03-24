<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\UserCashBuyData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Utils\DocNoMaker;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\VoucherInfoData;
use App\Data\User\UserData;

class LimitBuy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:ltbuy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '挂买单';

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
     * 
     * 修改了参数
     * @author zhoutao
     * @date   2017.8.24
     */
    public function handle()
    {
        $this->info("输入买方优惠券号:");
        $voucherNo = trim(fgets(STDIN));
        $this->info("输入买方买的数量，单位份数:");//份
        $count = trim(fgets(STDIN));
        $this->info("输入买方买的单价:");
        $price = trim(fgets(STDIN));
        $this->info("输入买方买的代币类型:");
        $coinType = trim(fgets(STDIN));
        $this->info("输入买方手机号:");
        $mobile = trim(fgets(STDIN));
        $this->info("输入卖方单号:");
        $sellNo = trim(fgets(STDIN));
    
        $date = date('Y-m-d H:i:s');

        $userFac= new UserData();
        $user = $userFac->getUser($mobile);
        $session = resolve('App\Http\Utils\Session');
        $session->userid = $user->id;

        $docNo = new DocNoMaker();
        $buyNo = $docNo->Generate('TB');

        $voucherFreezetime = 0;
        if (!empty($voucherNo) && $voucherNo != 'null') {
            //取券的冻结期
            $storageData = new VoucherStorageData();
            $storageInfo = $storageData->getStorageInfo($voucherNo);
            if ($storageInfo != null) {
                $voucherData = new VoucherInfoData();
                $voucherInfo = $voucherData->getByNo($storageInfo->vaucherstorage_vouchernovoucherNo);
                if ($voucherInfo != null) {
                    $voucherFreezetime = $voucherInfo->voucher_locktime;
                }
            }
        }

         $userCashBuyData = new UserCashBuyData();
        $userCashBuy = $userCashBuyData->addBuyOrder($buyNo, $count, $price, $coinType, $date, $voucherNo, TranactionBuyData::LEVEL_TYPE_PRODUCT);
        dump($userCashBuy);
        if ($userCashBuy) {
            $transactionOrderData = new TranactionOrderData();
        
        
            $count = $transactionOrderData->buyTransOrder($count, $price, $buyNo, $sellNo, $date, $voucherNo, $voucherFreezetime);
        }
        
    }
}
