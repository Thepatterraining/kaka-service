<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\UserData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\CoinSellData;
use App\Data\Utils\DocNoMaker;

class LimitSell extends Command
{


    public static $USER_COIN_JOURNAL_NO_PREFIX = 'UOJ';
    public static $TRANS_SELL_NO_PREFIX = 'TS';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:ltsell';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '挂卖单';

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
        $docNo = new DocNoMaker();

        $this->info("输入卖方用户手机号:");
        $mobile = trim(fgets(STDIN));
        $this->info("输入卖方资产类型:");
        $cointype = trim(fgets(STDIN));
        $this->info("输入卖方挂单数量:"); //0.0073 平米
        $amount = trim(fgets(STDIN));
        $this->info("输入卖方挂单价格:");
        $price = trim(fgets(STDIN));


        $this->info("确认挂单？Y:n");
        $sure = trim(fgets(STDIN));


        $date = date('Y-m-d H:i:s');
 
        if("Y"==    $sure ) {

                $userFac= new UserData();
                $user = $userFac->getUser($mobile);
                $session = resolve('App\Http\Utils\Session');
                $session->userid = $user->id;

                $userCoinJournalNo = $docNo->Generate(self::$USER_COIN_JOURNAL_NO_PREFIX);
                $transactionSellNo = $docNo->Generate(self::$TRANS_SELL_NO_PREFIX);
                $sellData = new CoinSellData();
                 $res = $sellData->addSellOrder(
                     $amount, $price, $cointype, 
                     $userCoinJournalNo,
                     $transactionSellNo, 
                     $date,
                     $price, 
                     $amount
                 );

                    dump($res);

            $this->info("OK");
        }else {
            $this->info("取消");
        }
        
   

         //执行挂买单业务
        //  $userCashBuyData = new UserCashBuyData();
        // $userCashBuy = $userCashBuyData->addBuyOrder($userCashJournalNo, $transactionBuyNo, $count, $price, $coin, $date, $voucherNo);

        //
    }
}
