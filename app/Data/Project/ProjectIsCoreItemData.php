<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目分值
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectIsCoreItemData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectIsCoreItem';

    /**
     * 添加项目分值
     *
     * @param  $scoreid scoreDefine.id
     * @param  $val 分值
     * @param  $projectid 项目id
     * @param  $index 排序
     * @author zhoutao
     * @date   2017.10.17
     */
    public function add($scoreid, $val, $projectid, $index)
    {
        $projectScoreDefineData = new ProjectScoreDefineData;
        $scoreDefine = $projectScoreDefineData->get($scoreid);

        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->get($projectid);

        if (!empty($scoreDefine) && !empty($projectInfo)) {
            $model = $this->newitem();
            $model->project_id = $projectInfo->id;
            $model->project_no = $projectInfo->project_no;
            $model->scoreitem_id = $scoreid;
            $model->scoreitem_value = $val;
            $model->scoreitem_name = $scoreDefine->score_name;
            $model->scoreitem_priority = $scoreDefine->score_priority;
            $model->scoreitem_index = $index;
            $model->scoreitem_scale = $scoreDefine->score_scale;
            $model->scoreitem_max = $scoreDefine->score_max;
            $model->scoreitem_min = $scoreDefine->score_min;
            $this->create($model);
        }
        
    }

    /**
     * 查询所有的评分
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.1
     */
    public function getScores($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        return $model::where($where)->get();
    }

}
