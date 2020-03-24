<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目标签定义
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectTagDefineData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectTagDefine';

    /**
     * 更新标签的项目数
     *
     * @param  $tagid id
     * @author zhoutao
     * @date   2017.10.17
     */
    public function saveProCount($tagid)
    {
        $tagDefine = $this->get($tagid);
        if (!empty($tagDefine)) {
            $tagDefine->tag_projectcount += 1;
            $this->save($tagDefine);
        }
    }

}
