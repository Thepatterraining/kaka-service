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
use App\Data\Product\AdminProductData;

class AdminEndProduct extends Controller
{

    protected $validateArray=[
        "productNo"=>"required|doc:product,PRS01,PRS02",
    ];

    protected $validateMsg = [
        "productNo.required"=>"请输入产品单号",
        "confirm.required"=>"请输入审核",
        "confirm.boolean"=>"审核值必须是布尔值",
    ];

    /**
     * 终止产品
     *
     * @param   $productNo
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.27
     */
    public function run()
    {
        $request = $this->request->all();
        $productNo = $request['productNo'];
        $adminData = new AdminProductData;

        $adminData->termination($productNo);

        $this->Success();
    }
}
