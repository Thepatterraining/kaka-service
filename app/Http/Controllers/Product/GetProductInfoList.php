<?php

namespace App\Http\Controllers\Product;

use App\Data\Item\FormulaData;
use App\Data\Product\CurveData;
use App\Data\Product\InfoData;
use App\Data\Item\InfoData as ItemInfoData;
use App\Data\Product\TrendData;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\Product\TrendAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use App\Http\Adapter\Item\InfoAdapter as ItemInfoAdapter;

class GetProductInfoList extends Controller
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
     * @api {post} product/getproductinfolist 查询产品列表
     * @apiName ProductList
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
     *               "no" => "PRO2017051000220333526"  产品单据号
     *               "name" => "测试一号"   产品名称
     *               "cointype" => "KKC-BJ0001"  代币类型
     *               "starttime" => "2017-05-10 00:22:03"
     *               "status" => array:2 [
     *               "no" => "PRS02"
     *               "name" => "发售中"
     *               ]
     *               "owner" => 262
     *               "feetype" => array:2 [
     *               "no" => "FR01"
     *               "name" => "价内"
     *               ]
     *               "feerate" => "0.00270"
     *               "voucherenable" => 1
     *               "price" => "1400.000"
     *               "count" => "10.000000000"
     *               "amount" => "14000.000"
     *               "sellno" => "TS2017051000220362654"
     *               "frozentime" => 7776000
     *               "img" => "/upload/KKC-BJ0001/img1.jpg"
     *               "wechatImg" => "/upload/KKC-BJ0001/img1.jpg" //微信项目图片
     *               "item" => array:11 [  项目信息
     *               "itemName" => "德胜房产系列001号"
     *               "*itemRegion" => "西城"
     *               "itemKkName" => "咔咔北京数字一号房产"
     *               "itemCompound" => "双旗杆东里"
     *               "itemLayout" => "2室1厅1厨1卫"
     *               "itemPrice" => 147000
     *               "itemSpace" => "50.55"
     *               "changeDate" => "2024-09-01 00:00:00"
     *               "itemSchool" => "西城"
     *               "itemTerm" => 7
     *               "rose" => "339.00000"
     *               }
     *               "curve" : {
     *                   "no" => "KKC-BJ0001"
     *                   "id" => 1
     *                   "price" => "292.89"   价格
     *                   "time" => "2011-09-27"  时间
     *                   "pricetype" => {
     *                       "no" => "PROP01"
     *                       "name" => "人工录入"
     *                   }
     *                },...
     *                "productCount" => "10.000000000"   数量
     *                "productSurplusCount" => 10   剩余数量
     *
     *      }
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new InfoData();
        $adapter = new InfoAdapter();
        $formulaData = new FormulaData();
        $curveData = new CurveData();
        $trendData = new TrendData();
        $trendAdapter = new TrendAdapter();
        $itemData = new ItemInfoData();
        $projectAdapter = new ItemInfoAdapter;
        $sellData = new TranactionSellData();
        $sellAdapter = new TranactionSellAdapter();


        //产品开始时间到，就开始
        $data->productStart();

        //产品秒杀完成时间到，就结束
        $data->productSeckillEnd();
        
        $filters = $adapter->getFilers($request);
        if (empty($filters)) {
            $item = $data->getProducts($filters, $pageSize, $pageIndex);//
        } else {
            
            $orderBy['created_at'] = 'desc';
            $item = $data->query($filters, $pageSize, $pageIndex, $orderBy);//
        }
        
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            //查询项目图片
            $imgs = $formulaData->getItemImg($arr['cointype'], $formulaData::$FORMULA_ITEM_IMG_TYPE);
            $arr['img'] = array_get($imgs, 0, null);
            //查询微信的项目图片
            $imgs = $formulaData->getItemImg($arr['cointype'], FormulaData::FORMULA_WECHAT_ITEM_IMG_TYPE);
            $arr['wechatImg'] = array_get($imgs, 0, null);
            //查询项目信息
            $itemInfo = $itemData->getInfo($arr['cointype']);
            // $itemInfo['rose'] = 500; //涨幅
            $arr['item'] = $itemInfo;
            //查询曲线
            $curves = $trendData->getCurves($arr['cointype'], 10);
            $trends = [];
            if (count($curves) > 0) {
                foreach ($curves as $v) {
                    $trend = $trendAdapter->getDataContract($v);
                    $trends[] = $trend;
                }
            }
            $arr['curve'] = $trends;

            //查询房产类型和比例因子
            $projectInfo = $itemData->getItem($arr['cointype']);
            $projectInfoItem = $projectAdapter->getDataContract($projectInfo);
            $arr['houseType'] = $projectInfoItem['houseType'];
            $arr['scale'] = $projectInfoItem['scale'];

            //查询卖单
            
            $sellInfo = $sellData->getByNo($arr['sellno']);
            $sellInfo = $sellAdapter->getDataContract($sellInfo);
            $arr['productCount'] = $sellInfo['touserShowcount'];
            $arr['productSurplusCount'] = $sellInfo['touserShowcount'] - ($sellInfo['transcount'] / $sellInfo['scale']);
            $res[] = $arr;
        }
        
        $item['datetime'] = date('Y-m-d H:i:s');
        $item['items'] = $res;
        $this->Success($item);
    }
}
