<?php

namespace App\Http\Controllers\Product;

use App\Data\Product\InfoData;
use App\Data\Product\TrendData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\Product\TrendAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveTrend extends Controller
{

    protected $validateArray=[
        "data"=>"array|required",
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入id!",
    ];


    /**
     * 修改产品价格
     *
     * @param   $id
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.30
     */
    public function run()
    {
        $request = $this->request->all();
        $id = $request['id'];

        $data = new TrendData();
        $adapter = new TrendAdapter();

        $model = $data->get($id);
        $trendInfo = $adapter->getData($this->request);
        $adapter->saveToModel(false, $trendInfo, $model);
        $data->save($model);

        $res = $adapter->getDataContract($model);

        return $this->Success($res);
    }
}
