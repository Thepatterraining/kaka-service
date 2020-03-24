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

class GetFromula extends Controller
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
        for ($i = 5;; $i++) {
            if ($i > 11) {
                break;
            }
            if ($i < 8) {
                $i = '0' . $i;
            }
            $type = "";
            $item = $data->getFormula($coinType, 'IFT'.$i);
            foreach ($item as $k => $v) {
                $arr = $adapter->getDataContract($v);
                if (count($arr) > 0) {
                    if ($arr['image'] != null) {
                        $arr['img'] = explode(',', $arr['image']);
                        foreach ($arr['img'] as $index => $img) {
                            $arr['img'][$index] = $img.'?_17.9.26.2';
                        }
                        unset($arr['image']);
                    }
                    $res[] = $arr;
                }
            }
            //            foreach ($res as $k => $v) {
            //                $img[$k] = $v['image'];
            //                if ($type == $v['type']['no']) {
            //                    $img[$k] = $v['image'];
            ////                    unset($res[$k - 1]);
            //                    $res[$k]['img'] = $img;
            //                }
            //                $type = $v['type']['no'];
            //            }
        }

        $this->Success($res);
    }
}
