<?php
namespace App\Http\Controllers\Project;

use App\Data\Project\ProjectInfoData;
use App\Http\Controllers\Controller;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Sys\ModelData;

class GetContracts extends Controller
{
    protected $validateArray = array(
        "coinType" => "required",
    );

    protected $validateMsg = [
        "coinType.required" => "请输入代币类型！",
    ];

    /**
     * 获取项目租赁合同
     *
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     * @date    2018.06.22
     */
    public function run()
    {
        $request = $this->request->all();
        $coinType = $request['coinType'];

        $projectInfoData = new ProjectInfoData();
        $resourceIndexData = new ResourceIndexData();

        $project = $projectInfoData->newitem()->where('project_no', $coinType)->first();
        $id = $project->id;

        $modelData=new ModelData();
        $modelId=$modelData->getModelIdByModel($project);

        $res['resources']['group'] = ResourceIndexData::CONTRACT_IMG;
        $res['resources']['items'] = $resourceIndexData->getItem($modelId, $id, ResourceIndexData::CONTRACT_IMG);

        return $this->Success($res);
    }
}
