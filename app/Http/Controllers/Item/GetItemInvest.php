<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\FormulaData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData as ProductInfoData;
use App\Data\Item\InfoData as ItemInfoData;

class GetItemInvest extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:product",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入产品编号!",
    ];

    /**
     * 查询产品得到代币类型
     *
     * @author  zhoutao
     * @version 0.2
     * @date    2017.5.2
     *
     * 项目详情 查询项目信息
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function run()
    {
        $no = $this->request->input('no');
        $data = new ItemInfoData();
        $formulaData = new FormulaData();
        $productData = new ProductInfoData();

        $coinType = $productData->getCoinType($no);
        
        //查询图片和文件
        $res = $formulaData->getInvestInfo($coinType);

        //查询投资分析
        $investment = $data->getInvestInfo($coinType);
        $res['investment'] = $investment;

        $this->Success($res);
    }
}
