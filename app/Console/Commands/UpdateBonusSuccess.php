<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Item\InfoData;
use App\Data\User\CoinAccountData;
use App\Data\Bonus\ProjBonusItemData;
use App\Data\User\CashAccountData;
use App\Data\User\CashOrderData;
use Illuminate\Support\Facades\DB;
use App\Data\Bonus\ProjBonusData;

class UpdateBonusSuccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:updateBonusSuccess {no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     * s
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
        $bonusNo = $this->argument('no');

        DB::beginTransaction();
        $reportUseCoinItemDayData=new ReportUserCoinItemDayData();
        $reportUseCoinDayData=new ReportUserCoinDayData();
        $itemInfoData=new InfoData();
        $bonusItemData = new ProjBonusItemData;
        $ProjBonusData = new ProjBonusData;

        //查询分红单信息
        $bonus = $ProjBonusData->getByNo($bonusNo);
        if (!empty($bonus)) {
            $date = date('Y-m-d H:i:s');
            $rightNo = $bonus->bonus_rightno; //确权单号
            $authDate = $bonus->bonus_authdate; //确权时间
            $dealCash = $bonus->bonus_dealcash;
            $status = $bonus->bonus_status;
            $coinType = $bonus->bonus_proj;
            $unit = $bonus->bonus_unit;

            $userCoinInfo=$reportUseCoinItemDayData->getHolding($authDate, $coinType);
            $coinInfo=$itemInfoData->getItem($coinType);
            $square=$coinInfo->space;



                //查询确权单信息 循环用户发分红
            foreach($userCoinInfo as $value){
                $userInfo=$reportUseCoinDayData->getReportByNo($value->report_no);
                $count = $value->report_holding; //确权时候该用户该代币的数量
                $pending = floor((($bonus->bonus_plancash-$bonus->bonus_planfee) * $count /$square) *100) / 100; //给用户发的分红金额 floor 保留两位
                $userid = $userInfo->report_user; //用户id
                $cash = $pending;
                //只有大于最小单位的才给分红
                if (bccomp($count, $unit, 9) === 1 || bccomp($count, $unit, 9) === 0) {
                    //查询子表，把未成功的发分红
                    $bonusItem = $bonusItemData->getBonusItemDetails($bonusNo, $userid, $coinType, $authDate);
                    if (!empty($bonusItem) && $bonusItem->bonus_success == 0) {
                        //插入用户流水 在途减少 可用增加
                        $userCashAccountData = new CashAccountData;
                        $userCashAccountRes = $userCashAccountData->increaseCashReducePending($bonusNo, $cash, $pending, $userid, UserCashJournalData::BONUES_TYPE, UserCashJournalData::BONUS_STATUS, $date);
                        //更新分红子表为成功
                        $bonusItemData->saveSuccess($bonusNo, $userid, $coinType, $authDate);

                        //写入资金账单
                        $userCashOrderData = new CashOrderData();
                        $balance = $userCashAccountRes['accountCash'];
                        $cashOrderRes = $userCashOrderData->add($bonusNo, $cash, CashOrderData::BONUS_TYPE, $balance, $userid);
                    }
                        
                }
            }

            DB::commit();
            $this->info('ok');
        } else {
            $this->error("没查到这个单");
        }
        
    }
}
