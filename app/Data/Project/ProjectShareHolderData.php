<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目股东信息
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectShareHolderData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectShareHolder';

    /**
     * 创建项目股东信息
     *
     * @param  $projectid 项目id
     * @param  $holderid 股东id
     * @param  $capital 认缴资本
     * @param  $type 股东类型
     * @param  $name 名称
     * @param  $shareBonus 是否参加分红
     * @author zhoutao
     * @date   2017.10.21
     */
    public function add($projectid, $holderid, $capital, $type, $name, $shareBonus)
    {
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->get($projectid);

        if (!empty($projectInfo)) {
            $coinAmount = $projectInfo->project_coinammount;
            $percent = $capital / $coinAmount;
            $model = $this->newitem();
            $model->project_id = $projectInfo->id;
            $model->project_no = $projectInfo->project_no;
            $model->holder_id = $holderid;
            $model->holder_percent = $percent;
            $model->holder_capital = $capital;
            $model->holder_type = $type;
            $model->holder_typename = $name;
            $model->holder_sharebonus = $shareBonus;
            $this->create($model);
        }
        

    }

}
