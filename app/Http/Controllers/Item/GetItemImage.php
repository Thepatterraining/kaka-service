<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\FormulaData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\FormulaAdapter;
use App\Http\Adapter\Item\InfoAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData as ProductInfoData;

class GetItemImage extends Controller
{

    protected $validateArray=[
        "no"=>"required|doc:product",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入产品编号!",
    ];

    /**
     * 查询证照公式
     *
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function run()
    {
        $no = $this->request->input('no');
        $productData = new ProductInfoData();
        $coinType = $productData->getCoinType($no);

        $data = new FormulaData();
        $adapter = new FormulaAdapter();
        
        //户型图
        $layoutImg = $data->getLayoutImg($coinType, $data::$FORMULA_LAYOUT_IMG_TYPE);
        //外景图
        $locationImg = $data->getLayoutImg($coinType, $data::$FORMULA_LOCATION_MAP_IMG_TYPE);
        //内景图
        $interiorImg = $data->getLayoutImg($coinType, $data::$FORMULA_INTERIOR_MAP_IMG_TYPE);

        $res['layoutImg'] = $layoutImg . '?_17.9.26';
        $res['locationImg'] = $locationImg . '?_17.9.26';
        $res['interiorImg'] = $interiorImg . '?_17.9.26';
        
        $this->Success($res);
    }
}
