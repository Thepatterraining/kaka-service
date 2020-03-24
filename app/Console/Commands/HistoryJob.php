<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Report;
use Illuminate\Support\Facades\Storage;
use App\Data\User\UserData;
use App\Http\Adapter\AdapterFac;
use App\Data\Settlement\UserCashSettlementData;
use App\Data\Settlement\SysCashSettlementData;
use App\Data\Sys\LogData;
use App\Data\Cash\UserRechargeData;
use App\Data\Report\ReportSumsDayData;
use App\Data\Monitor\DebugInfoData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\User\UserRebateRankdayData;
use App\Data\Report\ReportUserCashDayData;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\Report\ReportTradeDayData;
use App\Data\Report\ReportRechargeDayData;
use App\Data\Report\ReportRechargeItemDayData;
use App\Data\Report\ReportWithdrawalDayData;
use App\Data\User\CoinAccountData;
use App\Data\Payment\PayChannelData;

class HistoryJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:hisdaily';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make HistoryDaily Sheet';
    
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

       

        // 得到开始时间和结束时间
        $dateStr = '2017-7-10 00:00:00';

        $start = date_create($dateStr);
        $end = date_create($dateStr);
       
        $lastStr=date("Y-m-d 0:00:00");
        var_dump($lastStr);
        $i=0;

        // $end = date("Y-m-d 00:00:00");
        // $start = date_create($end);
        // date_add($start, date_interval_create_from_date_string("-1 days"));
        // $start = date_format($start, 'Y-m-d H:i:s');
        $time=floor((strtotime($lastStr)-strtotime($dateStr))/86400);

        while($i<$time){
            dump("Begin.");
            date_add($end, date_interval_create_from_date_string("1 day"));
            dump($start);
            dump($end); 

            $userFac = new UserData();
            $max=$userFac->getMaxId($start);
            dump(date_format($start, "Y-m-d H:00:00").'==>'.$max);
            $id = 1;
            $startd=date_format($start, "Y-m-d");
            $endd=date_format($end, "Y-m-d");
            // $this->info("Make Daily Jobs : {$startd}->${endd}");
            while($id<=$max){
                //     //生成代币日报
                //     $this->info("Make User Coin Report");
                //     $coinRptData = new ReportUserCoinDayData();
                //     $res=$coinRptData->createReport(
                //         $id,
                //         date_format($start,"Y-m-d H:00:00"),
                //         date_format($end,"Y-m-d H:00:00"),
                //         'CYC02'
                //     );
                //     $coinAccountData=new CoinAccountData();
                //     $reportUserCoinItemDayData=new ReportUserCoinItemDayData();
                //     $item=$coinRptData->getById($id,$res['start']);
                //     $tmp=$coinAccountData->getInfo($id);

                //     if($item != null)
                //     {
                //         foreach($tmp as $value)
                //         {
                //             $reportUserCoinItemDayData->createReport($item->report_no,$value->usercoin_cointype);
                //         }
                //     }
                
                //生成返佣日报
                $userrbSubReport=new ReportUserrbSubDayData();
                $this->info("Make User Rebuy Report");
                $userrbSubReport->createReport(
                    $id,
                    date_format($start, "Y-m-d H:00:00"),
                    date_format($end, "Y-m-d H:00:00"),
                    'CYC02'
                );

                //     //生成现金日报
                //     $this->info("Make User Cash Report");
                //     $userCash=new ReportUserCashDayData();
                //     $userCash->createReport(
                //             $id,
                //             date_format($start,"Y-m-d H:00:00"),
                //             date_format($end,"Y-m-d H:00:00"),
                //             'CYC02'
                //     );
                $id++;
            }

            // $this->info("Make All User Settlement");

            // $userSettle=new UserCashSettlementData();

            // $userSettle->makeAllUserDaySettlement();


            // $this->info("Make Sys Settlement");

            // $sysSettle = new SysCashSettlementData();
            

            //生成交易日报
            // $this->info("Make User Trade Report");
            // $userTrade=new ReportTradeDayData();
            // $userTrade->makeReport(
            //         date_format($start,"Y-m-d H:00:00"),
            //         date_format($end,"Y-m-d H:00:00"),
            //         'CYC02'
            //     );

            // //生成返现日报
            // $this->info("Make User Withdrawal Report");
            // $userWithdrawal=new ReportWithdrawalDayData();
            // $userWithdrawal->makeReport(
            //         date_format($start,"Y-m-d H:00:00"),
            //         date_format($end,"Y-m-d H:00:00"),
            //         'CYC02'
            //     );

            // //生成充值日报
            // $this->info("Make User Recharge Report");
            // $rechargeRptData = new ReportRechargeDayData();
            // $res=$rechargeRptData->makeReport(
            //     date_format($start,"Y-m-d H:00:00"),
            //     date_format($end,"Y-m-d H:00:00"),
            //     'CYC02'
            // );
            // $payChannelData=new PayChannelData();
            // $reportRechargeItemDayData=new ReportRechargeItemDayData();
            // $item=$rechargeRptData->getById($res['start']);
            // $tmp=$payChannelData->getClassAll();

            // if($item != null)
            // {
            //     foreach($tmp as $value)
            //     {
            //         $reportRechargeItemDayData->makeReport($item->report_no,$value->id);
            //     }
            // }

            // 生成第三方平台入帐

            // $this->info("Enter Account of Third Payment. ");
            // $docFac = new UserRechargeData();
            // $docFac ->ThirdPartyRechargeIncomedocs(
            //     $start, $end, 1
            // );

            date_add($start, date_interval_create_from_date_string("1 day"));
            $i++;  
        }     

        // $this->info("Clear Sys Errors Before LastWeek");

        // $logFac = new LogData();
        // $lastWeek = date_create($end);
        // date_add($lastWeek, date_interval_create_from_date_string("-7 days"));
        // $lastWeek = date_format($lastWeek, 'Y-m-d H:i:s');
        // $logFac->clearBefore($lastWeek);
           
           
       
        // $this->info("CLear Sys Logs Befor LastWeek");
        // $logFac = new DebugInfoData();
        // $logFac->clearBefore($lastWeek);
    }
}
