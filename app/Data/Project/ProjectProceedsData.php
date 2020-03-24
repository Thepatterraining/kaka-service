<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目收益类型
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectProceedsData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectProceeds';

    /**
     * 创建项目收益类型
     *
     * @param  $coinType 代币类型
     * @param  $proceedsid proceedsType.id
     * @author zhoutao
     * @date   2017.10.16
     */
    public function add($coinType, $proceedsTypeid)
    {
        //查询proceedsType 
        $projectProceedsTypeData = new ProjectProceedsTypeData;
        $proceedsType = $projectProceedsTypeData->get($proceedsTypeid);

        if (!empty($proceedsType)) {
            $model = $this->newitem();
            $model->project_no = $coinType;
            $model->project_proceeds_id = $proceedsTypeid;
            $model->project_proceeds_name = $proceedsType->proceedstype_name;
            $model->project_proceeds_note = $proceedsType->proceedstype_note;
            $this->create($model);
        }
         
    }

    /**
     * 查询这个代币的所有收益类型
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getProceedsByNo($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        return $model::where($where)->get();
    }

}
