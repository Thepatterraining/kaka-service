<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目信息
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectInfoData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectInfo';

    protected $no = 'project_no';

    const HOLD_TYPE_COMPANY = 1;

    /**
     * 创建项目信息
     *
     * @param  $coinType 代币类型
     * @param  $name 项目名称
     * @param  $projectScale 项目因子
     * @param  $projectCoinAmmount 项目代币数量
     * @param  $projectStartTime 项目开始时间
     * @param  $investsType 项目投资类型id
     * @param  $status 项目状态id
     * @param  $score 项目总评分
     * @param  $bonusType 分红类型
     * @param  $bonusPeriods 分红期数
     * @param  $projectHoldType 持有人类型
     * @param  $projectHolderid 持有人id
     * @param  $projectHoldLast 持有年限
     * @author zhoutao
     * @date   2017.10.17
     * 
     * 增加类型参数
     * @param  $projectType 类型id
     * @author zhoutao
     * @date   2017.11.13
     */
    public function add($coinType, $name, $projectScale, $projectCoinAmmount, $projectStartTime, $investsType, $status, $score, $bonusType, $bonusPeriods, $projectHoldType, $projectHolderid, $projectHoldLast, $projectType)
    {
        //查询投资类型
        $projectInvestsTypeDefineData = new ProjectInvestsTypeDefineData;
        $investsTypeDefine = $projectInvestsTypeDefineData->get($investsType);

        //查询状态
        $projectStatusDefineData = new ProjectStatusDefineData;
        $statusDefine = $projectStatusDefineData->get($status);

        //查询类型
        $projectTypeData = new ProjectTypeData;
        $type = $projectTypeData->get($projectType);

        $statusid = 0;
        $statusName = '';
        $statusDisplay = 0;
        $statusIndex = 0;
        if (!empty($statusDefine)) {
            $statusid = $statusDefine->id;
            $statusName = $statusDefine->status_name;
            $statusDisplay = $statusDefine->status_display;
            $statusIndex = $statusDefine->status_index;
        }

        if (!empty($investsTypeDefine)) {
            $model = $this->newitem();
            $model->project_no = $coinType;
            $model->project_name = $name;
            $model->project_score = $score;
            $model->project_scale = $projectScale;
            $model->project_coinammount = $projectCoinAmmount;
            $model->project_starttime = $projectStartTime;
            $model->project_investstype_id = $investsTypeDefine->id;
            $model->project_investstype_name = $investsTypeDefine->investstype_name;
            $model->project_current_status = $statusid;
            $model->project_current_status_name = $statusName;
            $model->project_current_status_display = $statusDisplay;
            $model->project_current_status_index = $statusIndex;
            $model->project_status_start = $projectStartTime;
            $model->project_bonustype = $bonusType;
            $model->project_bonusperiods = $bonusPeriods;
            $model->project_holdtype = $projectHoldType;
            $model->project_holderid = $projectHolderid;
            $model->project_hold_last = $projectHoldLast;
            $model->project_status_end = date('Y-m-d H:i:s', strtotime($projectStartTime . '+1 month'));
            if (!empty($type)) {
                $model->project_type = $projectType;
            }
            $this->create($model);
            return $model->id;
        }

        return 0;
        
    }

}
