<?php
namespace App\Http\Controllers\Project;

use App\System\Resource\Data\ResourceGroupData;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Project\ProjectInfoData;
use App\Http\Controllers\Controller;

class GetResource extends Controller
{
    protected $validateArray=array(
        "coinType"=>"required",
    );

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型！",
    ];

    /**
     * 获取项目资源
     *
     * @param   $coinType 邀请码
     * @author  liu
     * @version 0.1
     * @date    2017.10.18
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coinType'];

        $projectInfoData=new ProjectInfoData();
        $resourceGroupData=new ResourceGroupData();
        $resourceIndexData=new ResourceIndexData();

        $itemInfo=$projectInfoData->newitem()->where('project_no', $coinType)->first();
        $itemId=$itemInfo->id;
        $itemName=$itemInfo->project_name;

        $res['coinType']=$coinType;
        $res['name']=$itemName;
        $res['resources']=array();
        $groupInfo=$resourceGroupData->newitem()->orderBy('resource_group_level', 'asc')->where('resource_model_id', $itemId)->get();
        $i=0;
        if(!$groupInfo->isEmpty()) {
            foreach($groupInfo as $group)
            {   
                $res['resources'][$i]['group']=$group->resource_group;
                $res['resources'][$i]['items']=$resourceIndexData->getItem($itemId, $group->resource_group_include);
                $i++;
            }
        }
        else
        {
            $res['resources']=null;
        }
        return $this->Success($res);
    }
}