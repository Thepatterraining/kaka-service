<?php

namespace App\Http\Controllers\Product;

use App\Data\Item\FormulaData;
use App\Data\Product\CurveData;
use App\Data\Product\InfoData;
use App\Data\Item\InfoData as ItemInfoData;
use App\Http\Adapter\Product\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Trade\TranactionSellAdapter;

class GetUserProductInfoList extends Controller
{

    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];

    /**
     *
     * @api {post} product/getuserproductinfolist 查询用户产品列表
     * @apiName UserProducts
     * @apiGroup Product
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageIndex : 1,
     *      pageSize  : 10
     *      filters : {
     *          'status' : 'PRS01 未开始 PRS02 发售中 PRS03 已售罄'
     *      }
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *               "no" => "PRO2017052215583034595" . 产品号
     *               "name" => "德胜房产系列001号20170517" 产品名称
     *               "cointype" => "KKC-BJ0001" 代币类型
     *               "starttime" => "2017-05-10 00:02:06" 开始时间
     *               "status" => array:2 [ 状态
     *               "no" => "PRS02"
     *               "name" => "发售中"
     *               ]
     *               "owner" => 262 发布人
     *               "feetype" => array:2 [ 手续费类型
     *               "no" => "FR01"
     *               "name" => "价内"
     *               ]
     *               "feerate" => "0.00270" 手续费率
     *               "voucherenable" => 1 是否可用代金券
     *               "price" => "1800.000" 单价
     *               "count" => "200.000000000" 数量
     *               "amount" => "360000.000" 总价
     *               "sellno" => "TS2017052215583086917" 卖单号
     *              "productPrice" => 价格
     *               "frozentime" => 7776000 冻结时间
     *               "productCount" => "200.000000000" 数量
     *               "productSurplusCount" => 198 剩余数量
     *               "countUser" => 2 认购人数
     *              "img"=>  项目图片
     *
     *      }
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $userid = $this->session->userid;
        $data = new InfoData();
        $adapter = new InfoAdapter();
        $formulaData = new FormulaData();
        $sellData = new TranactionSellData();
        $sellAdapter = new TranactionSellAdapter();

        //产品开始时间到，就开始
        $data->productStart();

        //产品秒杀完成时间到，就结束
        $data->productSeckillEnd();

        $request['filters']['owner'] = $userid;
        $filters = $adapter->getFilers($request);
        $item = $data->query($filters, $pageSize, $pageIndex);//
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);

            //查询项目图片
            $imgs = $formulaData->getItemImg($arr['cointype'], FormulaData::$FORMULA_ITEM_IMG_TYPE);
            $arr['img'] = array_get($imgs, 0, null);

            //查询卖单
            $sellInfo = $sellData->getByNo($arr['sellno']);
            $sellInfo = $sellAdapter->getDataContract($sellInfo);
            $arr['productPrice'] = $sellInfo['touserFeePrice'];
            $arr['productCount'] = $sellInfo['touserFeeCount'];
            $arr['productSurplusCount'] = $sellInfo['touserFeeCount'] - ($sellInfo['transcount'] / $sellInfo['scale']);

            //查询有多少人认购
            $countUser = $data->getCountUser($arr['sellno']);
            $arr['countUser'] = $countUser[0]->countUser;
            $res[] = $arr;
        }


        $item['items'] = $res;
        $this->Success($item);
    }
}
