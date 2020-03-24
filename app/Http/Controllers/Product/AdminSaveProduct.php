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

class AdminSaveProduct extends Controller
{

    protected $validateArray=[
        "productNo"=>"required|doc:product,PRS10",
    ];

    protected $validateMsg = [
        "productNo.required"=>"请输入产品单号",
    ];

    /**
     * 修改产品信息
     *
     * @param   $productNo
     * @param   $data
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.27
     */
    public function run()
    {
        $request = $this->request->all();
        $productNo = $request['productNo'];
        $data = [];
        $adapter = new InfoAdapter;
        if ($this->request->has('data')) {
            $data = $adapter->getData($this->request);
        }
        $adminData = new AdminProductData;

        $product = $adminData->saveProduct($productNo, $data);

        $product = $adapter->getDataContract($product);
        

        $this->Success($product);
    }
}
