<?php
namespace App\Data\Project;

use App\Data\IDataFactory;
use App\Http\Adapter\Project\ProjectInfoItemDefineAdapter;

    /**
     * 项目类型信息关联
     *
     * @author zhoutao
     * @date   2017.9.19
     */
class ProjectTypeItemData extends IDatafactory
{
    protected $modelclass = 'App\Model\Project\ProjectTypeItem';

    protected $no = 'item_id';

    /**
     * 查询项目类型的所有信息定义
     *
     * @param  $typeid 类型id
     * @author zhoutao
     * @date   2017.10.13
     */
    public function getInfoItemDefines($typeid)
    {
        $projectInfoItemDefineData = new ProjectInfoItemDefineData;
        $projectInfoItemDefineAdapter = new ProjectInfoItemDefineAdapter;

        $model = $this->modelclass;
        $where['projtype_id'] = $typeid;
        $typeItems = $model::where($where)->orderBy('item_index', 'asc')->get();

        $items = [];
        $properties = ['name','dataType'];
        foreach ($typeItems as $typeItem) {
            $itemid = $typeItem->item_id;
            $infoItemDefine = $projectInfoItemDefineData->get($itemid);
            
            if (!empty($infoItemDefine)) {
                $items[] = $projectInfoItemDefineAdapter->getDataContract($infoItemDefine, $properties);
            }
           
        }

        return $items;
    }
}
