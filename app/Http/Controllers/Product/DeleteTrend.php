<?php

namespace App\Http\Controllers\Product;

use App\Data\Product\InfoData;
use App\Data\Product\TrendData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\Product\TrendAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteTrend extends Controller
{

    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入id!",
        "id.exists"=>"该项不存在!",
    ];


    /**
     * 删除产品价格
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

        $data->delete($id);

        return $this->Success();
    }
}
