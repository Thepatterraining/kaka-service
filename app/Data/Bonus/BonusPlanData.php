<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\Sys\LockData;
use Illuminate\Support\Facades\DB;

class BonusPlanData
{
    /**
     * 分红计划类型对应分红周期
     */
    private $bonusPlanTypeToCycle = [
        1 => 'PBSC01',
        2 => 'PBSC04',
        3 => 'PBSC02',
        4 => 'PBSC03',
    ];

    /**
     * 执行分红计划
     * @param $planNo 计划单号
     * @author zhoutao
     * @date 2017.11.10
     * 
     * 增加了分红周期
     * @author zhoutao
     * @date 2017.11.22
     */
   public function executeBonusPlan($planNo)
   {
        $lk = new LockData();
        $key = 'bonusPlan' . $planNo;
        $lk->lock($key);

        $projBonusData = new ProjBonusData;

        $date = date('Y-m-d H:i:s');

        $projBonusPlanItemData = new ProjBonusPlanItemData;
        $projBonusPlanData = new ProjBonusPlanData;
        $bonusPlan = $projBonusPlanData->getByNo($planNo);

        if (!empty($bonusPlan)) {
            $counts = $bonusPlan->bonsuplan_counts;
            $planFee = $bonusPlan->bonusplan_fee;
            $amount = $bonusPlan->bonusplan_cash;
            $unit = $bonusPlan->bonusplan_unit;
            $startTime = $bonusPlan->bonusplan_starttime;
            $endTime = $bonusPlan->bonusplan_endtime;
            $coinType = $bonusPlan->bonusplan_coin;
            $status = $bonusPlan->bonusplan_status;
            $typeid = $bonusPlan->bonusplan_typeid;
            $statusArray = [ProjBonusPlanData::APPLY_STATUS, ProjBonusPlanData::EXECUTING_STATUS];
            if (in_array($status, $statusArray)) {
                DB::beginTransaction(); 
                //如果达到开始时间，更新分红计划为执行中
                if ($date >= date('Y-m-d H:i:s', strtotime($startTime)) && $date < date('Y-m-d H:i:s', strtotime($endTime))) {
                    $projBonusPlanData->saveStatus($planNo, ProjBonusPlanData::EXECUTING_STATUS);
                } else if ($date >= date('Y-m-d H:i:s', strtotime($endTime))) {
                    //如果达到结束时间，更新分红计划为已完成
                    $projBonusPlanData->saveStatus($planNo, ProjBonusPlanData::COMPLETED_STATUS);
                }
                $bonusPlanItem = $projBonusPlanItemData->getPlanItemByNo($planNo);
                if (!empty($bonusPlanItem)) {
                    $bonusInstalment = $bonusPlanItem->bonusplan_index;
                    $planItemData = $bonusPlanItem->bonusplan_date;
                    $bonusPlanItemStatus = $bonusPlanItem->bonusplan_status;
                    if ($date >= date('Y-m-d H:i:s', strtotime($planItemData)) && $bonusPlanItemStatus == ProjBonusPlanItemData::APPLY_STATUS) {
                        //创建分红
                        $amount /= $counts;
                        $planFee /= $counts;
                        $bonusNo = $projBonusData->createBonus('', $planItemData, $amount, $planFee, $unit, $startTime, $endTime, $coinType, $bonusInstalment, $this->bonusPlanTypeToCycle[$typeid]);
                        // dump($bonusNo);
                        //审核分红
                        $projBonusData->bonusTrue($bonusNo);
                        
                        //更新分红计划的实际金额
                        $bonus = $projBonusData->getByNo($bonusNo);
                        $dealFee = $bonus->bonus_dealfee;
                        $dealCash = $bonus->bonus_dealcash;
                        $bonusPlan->bonusplan_dealfee += $dealFee;
                        $bonusPlan->bonusplan_dealcash += $dealCash;
                        $projBonusPlanData->save($bonusPlan);
                        
                        //更新分红计划
                        $projBonusPlanItemData->saveSuccess($planNo, $bonusNo);
                    }
                }
                DB::commit();
            }
        }
        $lk->unlock($key);
    }

    /**
     * 遍历所有分红计划，执行
     *
     * @author zhoutao
     * @date   2017.11.12
     */
    public function execBonusPlans()
    {
        $projBonusPlanData = new ProjBonusPlanData;
        $bonusPlans = $projBonusPlanData->getExecBonusPlans();

        foreach ($bonusPlans as $bonusPlan) {
            $planNo = $bonusPlan->bonusplan_no;
            $this->executeBonusPlan($planNo);
        }

    }
}
