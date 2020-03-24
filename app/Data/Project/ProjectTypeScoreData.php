<?php
namespace App\Data\Project;

use App\Data\IDataFactory;
use App\Http\Adapter\Project\ProjectScoreDefineAdapter;

    /**
     * 项目分值信息关联
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class ProjectTypeScoreData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectTypeScore';

    /**
     * 查询这个类型的所有分值信息
     *
     * @param  $typeid 类型id
     * @author zhoutao
     * @date   2017.10.13
     */
    public function getScores($typeid)
    {
        $projectScoreDefineData = new ProjectScoreDefineData;
        $projectScoreDefineAdapter = new ProjectScoreDefineAdapter;

        $model = $this->modelclass;
        $where['projtype_id'] = $typeid;
        $typeScores = $model::where($where)->orderBy('score_index')->get();

        $scores = [];
        foreach ($typeScores as $typeScore) {
            $scoreid = $typeScore->score_id;
            $scoreDefine = $projectScoreDefineData->get($scoreid);
            
            if (!empty($scoreDefine)) {
                $scores[] = $projectScoreDefineAdapter->getDataContract($scoreDefine);
            }
        }

        return $scores;
    }

}
