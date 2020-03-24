<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目年化收益
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectAnnualRateData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectAnnualRate';

    /**
     * 添加年化收益
     *
     * @param  $projectid 项目id
     * @param  $year 年份
     * @param  $reate 收益率
     * @param  $isHistory 是否历史
     * @param  $primary 是否平均收益
     * @author zhoutao
     * @date   2017.11.3
     */
    public function add($projectid, $year, $rate, $isHistory, $primary)
    {
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->get($projectid);
        if (!empty($projectInfo)) {
            $model = $this->newitem();
            $model->proj_id = $projectInfo->id;
            $model->project_no = $projectInfo->project_no;
            $model->annualrate_value = $rate;
            $model->annualrate_year = $year;
            $model->annualrate_ishistory = $isHistory;
            $model->annualrate_primary = $primary;
            $this->create($model);
        }
    }

    /**
     * 查询年化收益
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getAnnualRatesByNo($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        $where['annualrate_primary'] = 0;
        return $model::where($where)->orderBy('annualrate_year')->get();
    }

    /**
     * 查询平均年化
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.11.2
     */
    public function getAvgAnnualRateByNo($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        $where['annualrate_primary'] = 1;
        $info = $model::where($where)->first();
        return $info->annualrate_value;
    }

}
