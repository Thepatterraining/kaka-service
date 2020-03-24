<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\FormulaData;
use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserTypeData;

class GetItems extends Controller
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
     * @api {post} token/project/getprojects 查询项目列表
     * @apiName getprojects
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageIndex : '1',
     *      pageSize  : 10,
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
     *          {
     *              "cointype"  : KKC-BJ0001, //代币类型
     *              "name" : "德胜房产系列001号" //项目名称
     *               "kk_name" : "咔咔北京数字一号房产" //卡卡币名称 
     *               "compound" : "双旗杆东里" //小区
     *               "layout" : "2室1厅1厨1卫" //户型
     *               "diqu" : "西城" //地区
     *               "trade" : "德胜门" //商圈
     *               "number" : "1/5" //楼层
     *               "age" : "1979" //年代
     *               "space" : "50.50" //面积
     *               "rowards" : "南" //朝向
     *               "renovation" : "简装" //装修
     *               "school" : "西城区五路通小学" //教育配套
     *               "metro" : "近8号线安华桥站" //临近地铁
     *               "price" : 2000 //市场参考价
     *               "amount" : 5050 //资产总量
     *               "term" : 7 //投资期限
     *               "exchange_time" : "2024-09-01 00:00:00" //交割日期
     *               "school_district" : "西城" //教育属性
     *               "sublet" : { //分租类型
     *                   "no" : "IS01"
     *                   "name" : "按季度分租"
     *               }
     *               "rightDate" : "1970-01-01 00:00:00" //确权日期
     *               "bonusDate" : "1970-01-01 00:00:00" //分红日期
     *               "investment" : "小区位于三环里，西边是八达岭高速，东边是中轴路，北二环，北三环，德胜门，马甸桥，让您自驾畅通无堵，坐地铁8号线安华桥站也可以到家，门口多条公交线路，距离8号线安华桥站620米，交通便利；周边毗邻北京西城区五路通小学、北京三帆中学、北京师范大学第二附属中学西城实验学校、三帆中学裕中校区、北京第四中学、北京第八中学、北京第十三中学、北京第七中学等优质教育资源，教育实力雄厚；周边临近华联商厦、翠微百货、新华百货、北京积水潭医院、北京安贞医院、火箭军总医院、工商银行、北京银行、华夏银行等公共场所， 配套设施完善，生活十分便利。"
     *               "bonusRate" : "待定" //分红率
     *               "bonusCycle" : "季度" //分红周期
     *               "bonusPeriods" : 28 //分红期数
     *               "bonusRightDate" : "季度结束的最后一天" //确权日
     *               "bonusdate" : "季度开始的第一天" //分红日
     *               "rose" : "339.00000" //涨幅
     *               "newOrderPrice" : "1500.00" //最新成交价
     *               "monthAmount" : "2824935.41" //月成交额
     *               "startInterval" : "1700" //区间开始
     *               "endInterval" : "2300" //区间结束
     *               "feeRate" : {
     *                      "buyCashFeeRate" : "0.0027" //买方手续费率
     *                      "sellCashFeeRate" : 0 //卖方手续费率
     *                  },
     *                 "firstYearRose" : "92.00000", //第一年涨幅
     *                  "secondYearRose" : "92.00000", //第二年涨幅
     *                  "thirdYearRose" : "92.00000", //第三年涨幅
     *                  "fourthYearRose" : "92.00000", //第四年涨幅
     *                  "fifthYearRose" : "92.00000", //第五年涨幅
     *                  "dayAmount" : 1901085.5 //日成交额
     *                  "dayRose" : 2.9 //日涨幅
     *          },...
     *      }   
     *  }
     */
    public function run()
    {
        $data = new InfoData();
        $adapter = new InfoAdapter();
        $orderData = new TranactionOrderData;
        $userTypeData = new UserTypeData;
        
        $resquest = $this->request->all();
        $filers = $adapter->getFilers($resquest);
        $projects = $data->query($filers, $resquest['pageSize'], $resquest['pageIndex']);

        $res = [];
        foreach ($projects['items'] as $key => $project) {
            $project = $adapter->getDataContract($project);
            //只显示大于成交时间90天的
            $orderDate = $data->getStartTime($project['cointype']);
            if (date('Y-m-d') > $orderDate) {
                //最新成交价
                $project['newOrderPrice'] = $orderData->getOrderPrice($project['cointype']);
                //月成交额
                $project['monthAmount'] = $orderData->getMonthAmount($project['cointype']);
                //日成交额
                $project['dayAmount'] = $orderData->getDayAmount($project['cointype']);
                //区间
                $interval = $data->getInterval($project['cointype']);
                $project['startInterval'] = $interval['start'];
                $project['endInterval'] = $interval['end'];
                //查手续费率
                $project['feeRate'] = $userTypeData->getOrderFee($this->session->userid);
                //月涨幅
                $project['rose'] = $orderData->getMonthRose($project['cointype']);
                //日涨幅
                $project['dayRose'] = $orderData->getDayRose($project['cointype']);

                

                $res[] = $project;
            }

            
        }

        $this->Success($res);
    }
}
