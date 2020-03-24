<?php

namespace App\Http\Controllers\Product;

use App\Data\Item\FormulaData;
use App\Data\Product\CurveData;
use App\Data\Product\InfoData;
use App\Data\Item\InfoData as ItemInfoData;
use App\Data\User\UserData;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetAdminProductInfoList extends Controller
{

    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];

    /**
     * 查询用户自己的产品列表
     *
     * @param   $pageIndex
     * @param   $pageSize
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.27
     */
    public function run()
    {
        $request = $this->request->all();
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new InfoData();
        $adapter = new InfoAdapter();
        $userData = new UserData();
        $userAdapter = new UserAdapter();

        //产品开始时间到，就开始
        $data->productStart();

        //产品秒杀完成时间到，就结束
        $data->productSeckillEnd();

        
        $filters = $adapter->getFilers($request);
        $item = $data->query($filters, $pageSize, $pageIndex);//
        $userArray = ["loginid","name","idno","mobile"];
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            //查询出用户
            if ($arr["owner"]) {
                $useritem = $userData->get($arr["owner"]);
                $userarr = $userAdapter->getDataContract($useritem, $userArray, true);
                $arr["owner"] = $userarr;
            }
            $res[] = $arr;
        }

        $item['items'] = $res;
        $this->Success($item);
    }
}
