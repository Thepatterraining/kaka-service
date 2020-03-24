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


class AdminAuditProduct extends Controller
{

    protected $validateArray=[
        "productNo"=>"required|doc:product,PRS10",
        "confirm"=>"required|boolean",
    ];

    protected $validateMsg = [
        "productNo.required"=>"请输入产品单号",
        "confirm.required"=>"请输入审核",
        "confirm.boolean"=>"审核值必须是布尔值",
    ];

    /**
     * 审核产品
     *
     * @param   $productNo
     * @param   $confirm
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.27
     */
    public function run()
    {
        $request = $this->request->all();
        $productNo = $request['productNo'];
        $confirm = $request['confirm'];
        $adminData = new AdminProductData;

        if ($confirm) {
            //同意发布，修改状态
            $adminData->agree($productNo);
        } else {
            //拒绝发布
            $adminData->refuse($productNo);
        }

        $this->Success();
    }
}
