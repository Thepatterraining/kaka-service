<?php

namespace App\Http\Controllers\Product;

use App\Data\Product\InfoData;
use App\Data\Product\TrendData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\Product\TrendAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddTrend extends Controller
{

    protected $validateArray=[
        "data"=>"array|required",
        "data.price"=>"required",
        "data.no"=>"required",
        "data.time"=>"required",
        "data.pricetype"=>"required|dic:proj_pricetype",
    ];

    protected $validateMsg = [
        "data.price.required"=>"请输入单价!",
        "data.no.required"=>"请输入代币!",
        "data.time.required"=>"请输入时间!",
        "data.pricetype.required"=>"请输入类型!",
    ];


    /**
     * 添加产品价格
     *
     * @param   $data.price
     * @param   $data.no
     * @param   $data.time
     * @param   $data.pricetype
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.30
     */
    public function run()
    {
        $request = $this->request->all();

        $data = new TrendData();
        $adapter = new TrendAdapter();

        $model = $data->newitem();
        $trendInfo = $adapter->getData($this->request);
        $adapter->saveToModel(false, $trendInfo, $model);
        $data->create($model);

        $res = $adapter->getDataContract($model);

        return $this->Success($res);
    }
}
