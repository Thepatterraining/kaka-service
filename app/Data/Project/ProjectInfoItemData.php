<?php
namespace App\Data\Project;

use App\Data\IDataFactory;

    /**
     * 项目信息详情
     *
     * @author zhoutao
     * @date   2017.10.13
     */
class ProjectInfoItemData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectInfoItem';

    /**
     * 添加项目信息详情
     *
     * @param  $itemid 项目信息id
     * @param  $groupid 项目信息分组id
     * @param  $val 项目信息的值
     * @author zhoutao
     * @date   2017.10.14
     */
    public function add($itemid, $groupid, $val, $projectid)
    {
        //查询projectInfoItemDefine
        $projectInfoItemDefineData = new ProjectInfoItemDefineData;
        $infoItemDefine = $projectInfoItemDefineData->get($itemid);

        //查询projectInfoItemGroup
        $projectInfoItemGroupData = new ProjectInfoItemGroupData;
        $infoItemGroup = $projectInfoItemGroupData->get($groupid);

        //查询projectInfo
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->get($projectid);

        if (!empty($infoItemDefine) && !empty($infoItemGroup) && !empty($projectInfo)) {
            $model = $this->newitem();
            $model->project_id = $projectInfo->id;
            $model->project_no = $projectInfo->project_no;
            $model->proj_itemid = $itemid;
            $model->proj_itemvalue = $val;
            $model->proj_itemname = $infoItemDefine->item_name;
            $model->proj_itemgroupname = $infoItemGroup->group_name;
            $model->proj_itemgroupindex = $infoItemGroup->group_index;
            $model->proj_itemindex = 0;
            $model->proj_itemprenote = $infoItemDefine->item_prenote;
            $model->proj_itemlastnote = $infoItemDefine->item_lastnote;
            $this->create($model);
        }
        
    }

    /**
     * 查询项目信息详情
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getItemsByNo($coinType)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        return $model::where($where)->get();
    }

    /**
     * 根据代币类型和itemName查询一条信息
     *
     * @param  $coinType 代币类型
     * @param  $itemName 名称
     * @author zhoutao
     * @date   2017.11.6
     */
    public function getItemByName($coinType, $itemName)
    {
        $model = $this->modelclass;
        $where['project_no'] = $coinType;
        $where['proj_itemname'] = $itemName;
        return $model::where($where)->first();
    }

}
