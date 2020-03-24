<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目标签
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectTagsData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectTags';

    /**
     * 创建项目标签
     *
     * @param  $coinType 代币类型
     * @param  $tag 标签id
     * @author zhoutao
     * @date   2017.10.17
     */
    public function add($coinType, $tag)
    {
        $tagDefineData = new ProjectTagDefineData;
        $tagDefine = $tagDefineData->get($tag);

        if (!empty($tagDefine)) {
            $model = $this->newitem();
            $model->project_no = $coinType;
            $model->project_tagid = $tagDefine->id;
            $model->project_tagname = $tagDefine->tag_name;
            $this->create($model);

            //更新标签项目数
            $tagDefineData->saveProCount($tag);
        }
        
    }

    /**
     * 查询这个代币的所有标签
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getTagsByNo($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        return $model::where($where)->get();
    }

}
