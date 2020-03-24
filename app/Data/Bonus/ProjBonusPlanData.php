<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class ProjBonusPlanData extends IDatafactory
{

    protected $modelclass = 'App\Model\Bonus\ProjBonusPlan';

    protected $no = 'bonusplan_no';

    const APPLY_STATUS = 'BPS01'; //为执行
    const EXECUTING_STATUS = 'BPS02'; //执行中
    const COMPLETED_STATUS = 'BPS03'; //已完成

    /**
     * 创建计划
     *
     * @param  $coinType 代币类型
     * @param  $fee 管理费
     * @param  $cash 总金额
     * @param  $dealFee 实际管理费
     * @param  $dealCash 实际分红金额
     * @param  $unit 最小单位 当前为 0.01
     * @param  $autoCheck 是否自动
     * @param  $typeid 类型id
     * @param  $startTime 开始时间
     * @param  $endTime 结束时间
     * @param  $startIndex 开始期数
     * @author zhoutao
     * @date   2017.11.6
     */
    public function add($coinType, $fee, $cash, $unit, $autoCheck, $typeid, $startTime, $endTime, $startIndex)
    {
        $projBonusPlanItemData = new ProjBonusPlanItemData;
        $projBonusPlanTypeData = new ProjBonusPlanTypeData;
        $projBonusPlanType = $projBonusPlanTypeData->get($typeid);

        $planType = $projBonusPlanTypeData->JudgePlanType($typeid, $startTime, $endTime);

        $counts = $planType['count'];

        $no = '';
        if (!empty($projBonusPlanType)) {
            $docNo = new DocNoMaker;
            $no = $docNo->Generate('PBP');

            $model = $this->newitem();
            $model->bonusplan_no = $no;
            $model->bonusplan_coin = $coinType;
            $model->bonusplan_fee = $fee;
            $model->bonusplan_cash = $cash;
            $model->bonusplan_unit = $unit;
            $model->bonusplan_status = self::APPLY_STATUS;
            $model->bonusplan_autocheck = $autoCheck;
            $model->bonusplan_typeid = $typeid;
            $model->bonusplan_starttime = $startTime;
            $model->bonusplan_endtime = $endTime;
            $model->bonsuplan_counts = $counts;
            $model->bonsuplan_startindex = $startIndex;
            $this->create($model);

            $index = $startIndex;
            for ($i = 0; $i < $counts; $i++) {
                $projBonusPlanItemData->add($no, $index, $planType['date'][$i]);
                $index++;
            }
        }
        return $no;
    }

    /**
     * 更新分红计划状态
     *
     * @param  $planNo 分红计
     * @param  $status 状态划
     * @author zhoutao
     * @date   2017.11.8
     */
    public function saveStatus($planNo, $status)
    {
        $bonusPlan = $this->getByNo($planNo);
        if (!empty($bonusPlan)) {
            $bonusPlan->bonusplan_status = $status;
            $this->save($bonusPlan);

            //如果更新成已完成 把所有未完成的子表状态更新为已完成
            if ($status == self::COMPLETED_STATUS) {
                $projBonusPlanItemData = new ProjBonusPlanItemData;
                $projBonusPlanItemData->statusToCompleted($planNo);
            }
        }
        
    }

    /**
     * 查询所有状态在未开始和执行中的并且在时间里面的计划
     *
     * @author zhoutao
     * @date   2017.11.12
     */
    public function getExecBonusPlans()
    {
        $date = date('Y-m-d H:i:s');
        $model = $this->modelclass;
        $bonusPlans = $model::whereIn('bonusplan_status', [self::APPLY_STATUS, self::EXECUTING_STATUS])
                            ->where('bonusplan_starttime', '<=', $date)
                            ->get();
        return $bonusPlans;
    }

}
