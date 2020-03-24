<?php

namespace App\Http\Controllers\Product;

use App\Data\Item\FormulaData;
use App\Data\Product\CurveData;
use App\Data\Product\InfoData;
use App\Data\Item\InfoData as ItemInfoData;
use App\Data\Product\TrendData;
use App\Data\User\UserData;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\Product\TrendAdapter;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTrendList extends Controller
{

    protected $validateArray=[
        "pageIndex"=>"required",
        "pageSize"=>"required",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
    ];

    /**
     * 查询列表
     *
     * @param   $pageSize
     * @param   $pageIndex
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.30
     */
    public function run()
    {
        $request = $this->request->all();
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];

        $data = new TrendData();
        $adapter = new TrendAdapter();

        $filters = $adapter->getFilers($request);
        $trends = $data->query($filters, $pageSize, $pageIndex);

        $res = [];
        if (count($trends['items'])) {
            foreach ($trends['items'] as $val) {
                $arr = $adapter->getDataContract($val);
                $res[] = $arr;
            }
        }


        $this->Success($res);
    }
}
