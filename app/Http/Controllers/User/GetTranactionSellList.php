<?php

namespace App\Http\Controllers\User;

use App\Data\Item\FormulaData;
use App\Data\Project\ProjectInfoData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\System\Resource\Data\ResourceIndexData;
use App\Data\Sys\ModelData;

class GetTranactionSellList extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整数",
        "pageSize.integer"=>"每页数量必须是整数",
    ];

    //用户查询卖单
    /**
     * @param pageIndex 页码
     * @param pageSize 每页数量
     * @param status 状态
     * @param leveltype 一级市场
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new TranactionSellData();
        $adapter = new TranactionSellAdapter();
        $projectData = new ProjectInfoData();
        $formulaData = new FormulaData();
        $order = $adapter->getFilers($request);
        $filters = $adapter->getFilers($request);
        $item = $data->getSellList($pageSize, $pageIndex, $order, $filters, $userId);//
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            $project = $projectData->getByNo($arr['cointype']);
            //查询相关模型id
            $modelData=new ModelData();
            $modelId=$modelData->getModelIdByModel($project);
            //查询图片
            $resourceIndexData = new ResourceIndexData;
            $imgUrl = $resourceIndexData->getUrl($modelId, $project->id, ResourceIndexData::LOCATION_IMG);
            $arr['item']['cover_img1'] = $imgUrl;
            $arr['itemName'] = empty($project) ? '' : $project->project_name;
            $arr['count'] = $arr['count'] - $arr['transcount'];
            $arr['ammount'] = $arr['count'] * $arr['limit'];
            $arr['count'] = floatval(bcdiv($arr['count'], $arr['scale'], 9));
            $arr['ammount'] = sprintf("%.2f", $arr['ammount']);
            $arr['limit'] = sprintf("%.2f", $arr['limit']);
            $arr['createdTime'] = $arr['selltime']->format('Y-m-d H:i:s');
            $res[] = $arr;
        }

        $item['items'] = $res;
        $this->Success($item);
    }
}
