<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;

    /**
     * x项目分红计划类型
     *
     * @author liu
     * @date   2017.11.7
     */
class ProjBonusPlanTypeData extends IDatafactory
{
    protected $modelclass="App\Model\Bonus\ProjBonusPlanType";

    const CONST_STEP='PBP01';
    const CRONTAB_STEP='PBP02';

    public function JudgePlanType($id,$starttime,$endtime)
    {
        $model=$this->newitem();
        $planInfo=$model->where('id', $id)->first();
        if(!$planInfo) {
            return null;
        }
        $case=$planInfo->bonusplan_typestatus;
        switch($case)
        {
        case self::CONST_STEP:
        {
            $step=$planInfo->bonusplan_exp;
            $tmp_time=strtotime($starttime);
            $start=strtotime($starttime);
            $end=strtotime($endtime);
            $res=array();
            $res['count']=0;
            while($tmp_time>=$start && $tmp_time<=$end)
            {
                $tmp_date_right=date('Y-m-d H:i:s', $tmp_time);
                $res['count']++;
                $res['date'][]=$tmp_date_right;
                $tmp_date=date_create(date('Y-m-d H:i:s', $tmp_time));
                date_add($tmp_date, date_interval_create_from_date_string($step));
                $tmp_time=strtotime(date_format($tmp_date, 'Y-m-d H:i:s'));
            }
            break;
}
        default:
        {
            $res=null;
            break;
}
        }
        return $res;
    }

    public function add($typeName,$typeNote,$typeStatus,$exp)
    {
        $model=$this->newitem();
        $model->bonusplan_typename=$typeName;
        $model->bonusplan_typenote=$typeNote;
        $model->bonusplan_typestatus=$typeStatus;
        $model->bonusplan_exp=$bonusExp;
        $this->save($model);
    }
}
