<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;

class ProjBonusPlanItemData extends IDatafactory
{

    protected $modelclass = 'App\Model\Bonus\ProjBonusPlanItem';

    const APPLY_STATUS = 'BPIS01';
    const SUCCESS_STATUS = 'BPIS02';
    const COMPLETED_STATUS = 'BPIS03';

    /**
     * 创建计划子表
     *
     * @param  $no 主表单号
     * @param  $index 第几期
     * @param  $date 分红时间
     * @author zhoutao
     * @date   2017.11.6
     */
    public function add($no, $index, $date)
    {
        $model = $this->newitem();
        $model->bonusplan_no = $no;
        $model->bonusplan_index = $index;
        $model->bonusplan_status = self::APPLY_STATUS;
        $model->bonusplan_date = $date;
        $this->create($model);
    }

    /**
     * 查询最近的一期准备分红的数据
     *
     * @param  $no 计划单号
     * @author zhoutao
     * @date   2017.11.7
     */
    public function getPlanItemByNo($no)
    {
        $date = date('Y-m-d H:i:s');
        $model = $this->modelclass;
        $where['bonusplan_no'] = $no;
        $where['bonusplan_status'] = self::APPLY_STATUS;
        return $model::where($where)->where('bonusplan_date', '<', $date)->orderBy('bonusplan_index', 'asc')->first();
    }

    /**
     * 修改为成功
     *
     * @param  $no 计划单号
     * @param  $bonusNo 分红单号
     * @author zhoutao
     * @date   2017.11.7
     */
    public function saveSuccess($no, $bonusNo)
    {
        $bonusPlan = $this->getPlanItemByNo($no);
        if (!empty($bonusPlan)) {
            $bonusPlan->bonusplan_status = self::SUCCESS_STATUS;
            $bonusPlan->bonus_no = $bonusNo;
            $this->save($bonusPlan);
        }
        
    }

    /**
     * 把所有这个计划的准备执行变成已完成
     *
     * @param  $planNo 计划号
     * @author zhoutao
     * @date   2017.11.8
     */
    public function statusToCompleted($planNo)
    {
        $model = $this->modelclass;
        $where['bonusplan_no'] = $planNo;
        $where['bonusplan_status'] = self::APPLY_STATUS;
        $bonusPlanItems = $model::where($where)->orderBy('bonusplan_index', 'asc')->get();
        foreach ($bonusPlanItems as $bonusPlanItem) {
            $bonusPlanItem->bonusplan_status = self::COMPLETED_STATUS;
            $this->save($bonusPlanItem);
        }
    }

}
