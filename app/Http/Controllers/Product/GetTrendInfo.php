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

class GetTrendInfo extends Controller
{

    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入id",
    ];

    /**
     * 查询详细
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

        $trend = $data->get($id);
        $adapter = new TrendAdapter();

        $res = $adapter->getDataContract($trend);

        $this->Success($res);
    }
}
