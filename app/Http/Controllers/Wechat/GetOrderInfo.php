<?php

namespace App\Http\Controllers\Wechat;

use App\Data\Project\ProjectInfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetOrderInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:transaction_order,order_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号!",
        "no.exists"=>"单据号不存在!",
        "no.string"=>"单据号必须是字符串!",
    ];

    //查找提现详细信息
    /**
     * @param no 提现单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new TranactionOrderData();
        $adapter = new TranactionOrderAdapter();
        $projectInfoData = new ProjectInfoData();
        $filersWhere['filters']['no'] = $this->request->input('no');
        $filers = $adapter->getFilers($filersWhere);
        $item = $data->find($filers);
        $res = $adapter->getDataContract($item);
        $res['chktime'] = $res['chktime']->format('Y-m-d H:i:s');
        $projectInfo = $projectInfoData->getByNo($res['type']);
        $res['assetsName'] = empty($projectInfo) ? '' : $projectInfo->project_name;
        return $this->Success($res);
    }
}
