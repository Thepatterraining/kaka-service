<?php
namespace App\Data\Project;
use App\Data\IDataFactory;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\Bonus\ProjBonusData;

class ProjectBonusTypeData extends IDataFactory
{

    protected $modelclass="App\Model\Project\ProjectBonusType";

    const DAY_CHECK="PB01";
    const MONTH_CHECK="PB02";
    const SEASON_CHECK="PB03";
    const YEAR_CHECK="PB04";
 
    public function add($bonusName,$bonusType,$bonusCyc,$bonusConfirmInfo,$bonusConfirmExp,$bonusDiviendInfo,$bonusDiviendExp,$bonusRate)
    {
        $model=$this->newitem();
        $model->bonus_name=$bonusName;
        $model->bonus_type=$bonusType;
        $model->bonus_cyc=$bonusCyc;
        $model->bonus_confirminfo=$bonusConfirmInfo;
        $model->bonus_confirmexp=$bonusConfirmExp;
        $model->bonus_diviendinfo=$bonusDiviendInfo;
        $model->bonus_diviendexp=$bonusDiviendExp;
        $model->bonus_rate=$bonusRate;
        $model->save();
    }

    /**
     * 获取所有分红类型
     *
     * @author zhoutao
     * @date   2017.11.3
     */
    public function getBonusTypes()
    {
        $model = $this->modelclass;
        return $model::orderBy('bonus_index', 'desc')->get();
    }

    public function DiviendExpHandle($coinType)
    {
        $time=date("Y-m-d");
        $model=$this->newitem();
        $projectInfoData=new ProjectInfoData();

        $projectInfo=$projectInfoData->newitem()->where('project_no', $coinType)->first();
        $bonusInfo=$model->get($projectInfo->project_bonustype);

        if($bonusInfo) {
            $bonusType=$bonusInfo->bonus_type;
            $bonusDiviendExp=$bonusInfo->bonus_diviendexp;
            $bonusDiviendTime=date_create($bonusDiviendExp);
            $bonusCyc=$bonusInfo->bonus_cyc;
            $bonusDiviendStrto=strtotime($bonusDiviendTime);
            $timeStrto=strtotime($time);

            $year=date('Y');
            $month=date('m');
            $day=date('d');

            

            $projBonusData=new ProjBonusData();
            $bonus=$projBonusData->newitem()->orderBy('created_at', 'desc')->where('bonus_proj', $coinType)->where('bonus_status', ProjBonusData::SUCCESS_STATUS)->first();
            if($bonus) {
                $parttens="/\d+/";
                preg_match_all($patterns, $bonus->bonus_instalment, $arr);
                $bonusInstalment="第".$arr[0]++."期";
            }
            else
            {
                $bonusInstalment="第1期";
            }

            switch($bonusType)
            {
            case $self::WEEK_CHECK:
            {
                $timeCount=$bonusConfirmStrto-$timeStrto;
                $root=1;
                while($timeCount<86400 * $bonusCyc * $root * 7)
                {
                    $bonusCyc++;
                }
                $lastTimeCount=86400 * $bonusCyc * ($root-1);
                $strto=$timeCount - $lastTimeCount;
                if($strto<86400) {
                    $bonusConfirmTime=$bonusDiviendTime;
                    $bonusConfirmExp=$bonusInfo->bonus_confirmexp;
                    date_sub($bonusConfirmTime, date_interval_create_from_date_string($bonusConfirmExp." days"));
                    $bonusConfirmStartTime=$bonusDiviendTime;
                    date_sub($bonusConfirmStartTime, date_interval_create_from_date_string("1 week"));
                    $bonusNo=$projBonusData->createBonus('', $bonusConfirmTime, $amount, $planfee, $unit, $bonusConfirmStartTime, $bonusConfirmTime, $coinType, $bonusInstalment);
                    $projBonusData->bonusTrue($bonusNo);
                }
}
            case $self::MONTH_CHECK:
                {
                    $lastTimeCount=mktime(0, 0, 0, 1, $month, $year);
                if($timeCount == $lastTimeCount) {
                    $bonusConfirmTime=$bonusDiviendTime;
                    $bonusConfirmExp=$bonusInfo->bonus_confirmexp;
                    date_sub($bonusConfirmTime, date_interval_create_from_date_string($bonusConfirmExp." days"));
                    $bonusConfirmStartTime=$bonusDiviendTime;
                    date_sub($bonusConfirmStartTime, date_interval_create_from_date_string("1 month"));
                    $bonusNo=$projBonusData->createBonus('', $bonusConfirmTime, $amount, $planfee, $unit, $bonusConfirmStartTime, $bonusConfirmTime, $coinType, $bonusInstalment);
                    $projBonusData->bonusTrue($bonusNo);
                }
}
            case $self::SEASON_CHECK:
                {
                    $cycInfo=explode(' ', $bonusCyc);

                foreach($cycInfo as $cyc)
                    {
                    if($month==$cyc) {
                        $diviendLastTime=mktime(0, 0, 0, 1, $month+1, $year);
                        $diviendStartTime=$diviend - 86400;
                        if($bonusConfirmStrto>=$diviendStartTime && $bonusConfirmStrto<=$diviendLastTime) {
                            $bonusConfirmTime=$bonusDiviendTime;
                            $bonusConfirmExp=$bonusInfo->bonus_confirmexp;
                            date_sub($bonusConfirmTime, date_interval_create_from_date_string($bonusConfirmExp." days"));
                            $bonusConfirmStartTime=$bonusDiviendTime;
                            date_sub($bonusConfirmStartTime, date_interval_create_from_date_string("3 months"));
                            $bonusNo=$projBonusData->createBonus('', $bonusConfirmTime, $amount, $planfee, $unit, $bonusConfirmStartTime, $bonusConfirmTime, $coinType, $bonusInstalment);
                            $projBonusData->bonusTrue($bonusNo);
                        }
                    }
                }
}
            default:
            {
                break;
}
            }
            
        }
        return true;
    }

}