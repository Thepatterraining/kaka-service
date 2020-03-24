<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData as ProductInfoData;

class GetItemInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:product",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入产品编号!",
    ];

    /**
     *
     *
     * @api {post} item/getinfo 查询产品详细
     * @apiName 查询产品详细
     * @apiGroup Product
     * @apiVersion 0.0.1
     *
     * @apiParam {string} no 产品单据号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : "PRO2017051712051590100",
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
     *           "cointype" => "KKC-BJ0002"   代币类型
     *           "name" => "德胜房产系列002号"  项目名称
     *           "kk_name" => ""
     *           "compound" => "文联宿舍" 小区名称
     *           "layout" => ""
     *           "diqu" => "西城"  地区
     *           "trade" => "德胜门"  商圈
     *           "number" => ""
     *           "age" => ""
     *           "space" => "36.80"  面积
     *           "rowards" => ""
     *           "renovation" => ""
     *           "school" => ""
     *           "metro" => ""
     *           "price" => 155000  销售指导价
     *           "amount" => 0
     *           "term" => 8  投资期限
     *           "exchange_time" => "1970-01-01 00:00:00" 交割日期
     *           "school_district" => ""
     *           "sublet" => null
     *           "rightDate" => "1970-01-01 00:00:00"
     *           "bonusDate" => "1970-01-01 00:00:00"
     *           "investment" => ""  投资分析
     *           "bonusRate" => "3.00000" 分红率
     *           "bonusCycle" => "季度"  分红周期
     *           "bonusPeriods" => 32  分红期数
     *           "bonusRightDate" => "季度结束的最后一天"  确权日
     *           "bonusdate" => "季度开始的第一天"   分红日
     *           "rose" => "301.00000"  涨幅
     *           "productPrice" => "1800.000"  产品价格
     *           "productName" => "德胜房产系列001号20170510期" 产品名称
     *           "productFeeRate" => "0.00270" 费率
     *           "productCount" => "200.000000000" 产品数量
     *           "productSurplusCount" => 196 剩余数量
     *           "product" => array:14 [
     *               "no" => "PRO2017051712051590100"   产品单号
     *               "name" => "德胜房产系列001号20170510期"  产品名称
     *               "cointype" => "KKC-BJ0002"  代币类型
     *               "starttime" => "2017-05-10 00:02:06"  开始时间
     *               "status" => array:2 [   产品状态
     *                   "no" => "PRS03"
     *                   "name" => "已售罄"
     *               ]
     *               "owner" => 262 发布人
     *               "feetype" => array:2 [  手续费类型
     *                   "no" => "FR01"
     *                   "name" => "价内"
     *               ]
     *               "feerate" => "0.00270" 手续费率
     *               "voucherenable" => 1 是否可用代金券
     *               "price" => "1800.000" 单价
     *               "count" => "200.000000000" 数量，份数
     *               "amount" => "360000.000" 总价
     *               "sellno" => "TS2017051712051530012" 卖单号
     *               "frozentime" => 7776000 冻结时间
     *           ],
     *          "firstYearRose" : "92.00000", //第一年涨幅
     *                  "secondYearRose" : "92.00000", //第二年涨幅
     *                  "thirdYearRose" : "92.00000", //第三年涨幅
     *                  "fourthYearRose" : "92.00000", //第四年涨幅
     *                  "fifthYearRose" : "92.00000", //第五年涨幅
     *          insurance : "平安保险"
     *          bank : "中国银行" 
     *          orderUser : 0 //已购人数
     *          houseType : { //房屋署权
     *              "no" : "HT01",
     *              "name" : "商品房",
     *          }
     *          leaseType : '待出租' //租凭状态
     *          housePurpose : '普通住宅' //房屋用途
     *          region : '临近第3中学' //区域介绍
     *          traffic : '距离1号线地铁站100米' //交通位置
     *          houseRegion : '北三环中路10号院(文联宿舍)' //房屋位置
     *          scale : 0.01 比例因子
     *      }
     *  }
     */
    public function run()
    {
        $no = $this->request->input('no');

        $data = new ProductInfoData();
        $res = $data->getProduct($no);

        $this->Success($res);
    }
}
