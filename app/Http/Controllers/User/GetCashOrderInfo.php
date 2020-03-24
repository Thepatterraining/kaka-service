<?php

namespace App\Http\Controllers\User;

use App\Data\User\CashOrderData;
use App\Http\Adapter\User\CashOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCashOrderInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:user_cash_order,usercashorder_no",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号",
        "no.exists"=>"单据号不正确",
    ];

    /**
     * @api {post} user/getuserorderinfo 查询资金账单详细
     * @apiName 查询资金账单详细
     * @apiGroup CashOrder
     * @apiVersion 0.0.1
     *
     * @apiParam {string} no 资金账单单据号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : "UCO2017051712094226189",
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
     *                  项目转让
     *                "id" => 63
     *                   "no" => "TO2017052617584394769"  成交单号
     *                   "count" => "0.01000000"   成交数量 平米
     *                   "price" => "180000.000"   成交单价 平米
     *                   "cashRate" => "0.00270"   现金手续费费率
     *                   "coinRate" => "0.00000"   代币手续费费率
     *                   "cashFee" => "4.860"   现金手续费
     *                   "coinFee" => "0.00000000"   代币手续费
     *                   "buyNo" => "TB2017052617584226213"   买单号
     *                   "sellNo" => "TS2017052215583086917"   卖单号
     *                   "sellUserid" => 262   卖方用户id
     *                   "buyUserid" => 262    买方用户id
     *                   "sellCoinaccount" => 9   卖方代币账户
     *                   "sellCashaccount" => 306  卖方现金账户
     *                   "buyCoinaccount" => 9    买方代币账户
     *                   "buyCashaccount" => 306   买方现金账户
     *                   "cash" => "1795.140"    入账现金
     *                   "coin" => "0.01000000"   入账代币  平米
     *                   "amount" => "1800.000"   成交金额
     *                   "type" => "德胜房产系列001号"  项目种类
     *                   "chktime" => array:3 [
     *                   "date" => "2017-05-26 17:58:43.000000"  审核时间
     *                   "timezone_type" => 3
     *                   "timezone" => "Asia/Shanghai"
     *                   ]
     *                   "sellCashFeeType" => "FR01"  卖方现金手续费类型  FR00 免费 FR01 价内 FR02 价外
     *                   "sellCoinFeeType" => "FR00"  卖方代币手续费类型
     *                   "buyCashFeeType" => "FR02"   买方现金手续费类型
     *                   "buyCoinFeeType" => "FR00"   买方代币手续费类型
     *                   "buyCashFee" => "4.860"   买方现金手续费
     *                   "sellCoinFeeRate" => "0.00000" 卖方代币手续费率
     *                   "sellCoinFee" => "0.000000000"  卖方代币手续费
     *                   "scale" => "0.010"  比列因子
     *                   "touserShowPrice" => "1804.860"  显示价格
     *                   "touserShowCount" => "1.000000000"  显示数量
     *                   "typeNo" => "UCORDER02"     项目转让
     *                   "val2" => 0  优惠金额
     *
     *
     *
     *                  项目购买
     *                "id" => 63
     *                   "no" => "TO2017052617584394769"  成交单号
     *                   "count" => "0.01000000"   成交数量 平米
     *                   "price" => "180000.000"   成交单价 平米
     *                   "cashRate" => "0.00270"   现金手续费费率
     *                   "coinRate" => "0.00000"   代币手续费费率
     *                   "cashFee" => "4.860"   现金手续费
     *                   "coinFee" => "0.00000000"   代币手续费
     *                   "buyNo" => "TB2017052617584226213"   买单号
     *                   "sellNo" => "TS2017052215583086917"   卖单号
     *                   "sellUserid" => 262   卖方用户id
     *                   "buyUserid" => 262    买方用户id
     *                   "sellCoinaccount" => 9   卖方代币账户
     *                   "sellCashaccount" => 306  卖方现金账户
     *                   "buyCoinaccount" => 9    买方代币账户
     *                   "buyCashaccount" => 306   买方现金账户
     *                   "cash" => "1795.140"    入账现金
     *                   "coin" => "0.01000000"   入账代币   平米
     *                   "amount" => "1800.000"   成交金额
     *                   "type" => "德胜房产系列001号"  项目种类
     *                   "chktime" => array:3 [
     *                   "date" => "2017-05-26 17:58:43.000000"  审核时间
     *                   "timezone_type" => 3
     *                   "timezone" => "Asia/Shanghai"
     *                   ]
     *                   "sellCashFeeType" => "FR01"  卖方现金手续费类型  FR00 免费 FR01 价内 FR02 价外
     *                   "sellCoinFeeType" => "FR00"  卖方代币手续费类型
     *                   "buyCashFeeType" => "FR02"   买方现金手续费类型
     *                   "buyCoinFeeType" => "FR00"   买方代币手续费类型
     *                   "buyCashFee" => "4.860"   买方现金手续费
     *                   "sellCoinFeeRate" => "0.00000" 卖方代币手续费率
     *                   "sellCoinFee" => "0.000000000"  卖方代币手续费
     *                   "scale" => "0.010"  比列因子
     *                   "touserShowPrice" => "1804.860"  显示价格
     *                   "touserShowCount" => "1.000000000"  显示数量
     *                   "typeNo" => "UCORDER01"     项目购买
     *                   "val2" => 0  优惠金额
     *
     *                 项目认购
     *                  "id" => 63
     *                   "no" => "TO2017052617584394769"  成交单号
     *                   "count" => "0.01000000"   成交数量 平米
     *                   "price" => "180000.000"   成交单价 平米
     *                   "cashRate" => "0.00270"   现金手续费费率
     *                   "coinRate" => "0.00000"   代币手续费费率
     *                   "cashFee" => "4.860"   现金手续费
     *                   "coinFee" => "0.00000000"   代币手续费
     *                   "buyNo" => "TB2017052617584226213"   买单号
     *                   "sellNo" => "TS2017052215583086917"   卖单号
     *                   "sellUserid" => 262   卖方用户id
     *                   "buyUserid" => 262    买方用户id
     *                   "sellCoinaccount" => 9   卖方代币账户
     *                   "sellCashaccount" => 306  卖方现金账户
     *                   "buyCoinaccount" => 9    买方代币账户
     *                   "buyCashaccount" => 306   买方现金账户
     *                   "cash" => "1795.140"    入账现金
     *                   "coin" => "0.01000000"   入账代币   平米
     *                   "amount" => "1800.000"   成交金额
     *                   "type" => "德胜房产系列001号"  项目种类
     *                   "chktime" => array:3 [
     *                   "date" => "2017-05-26 17:58:43.000000"  审核时间
     *                   "timezone_type" => 3
     *                   "timezone" => "Asia/Shanghai"
     *                   ]
     *                   "sellCashFeeType" => "FR01"  卖方现金手续费类型  FR00 免费 FR01 价内 FR02 价外
     *                   "sellCoinFeeType" => "FR00"  卖方代币手续费类型
     *                   "buyCashFeeType" => "FR02"   买方现金手续费类型
     *                   "buyCoinFeeType" => "FR00"   买方代币手续费类型
     *                   "buyCashFee" => "4.860"   买方现金手续费
     *                   "sellCoinFeeRate" => "0.00000" 卖方代币手续费率
     *                   "sellCoinFee" => "0.000000000"  卖方代币手续费
     *                   "scale" => "0.010"  比列因子
     *                   "touserShowPrice" => "1804.860"  显示价格
     *                   "touserShowCount" => "1.000000000"  显示数量
     *                   "typeNo" => "UCORDER07"     项目购买
     *                   "val2" => 0  优惠金额
     *                     "productName" => "德胜房产系列001号20170510期"  产品名称
     *
     *
     *                      充值
     *                  "no" => "CR2017052617584199559" 充值单号
     *                   "amount" => "1794.860"  充值金额
     *                   "sysamount" => "1794.860"
     *                   "useramount" => "1794.860"
     *                   "status" => array:2 [ 状态
     *                   "no" => "CR03"
     *                   "name" => "已确认"
     *                   ]
     *                   "userid" => 262  用户id
     *                   "chkuserid" => 262 审核用户id
     *                   "bankid" => "" 用户银行卡后
     *                   "time" => "2017-05-26 17:58:41" 申请时间
     *                   "desbankid" => "110925871910801" 系统银行卡号
     *                   "chktime" => "2017-05-26 17:58:42" 审核时间
     *                   "success" => 1 是否成功 0 不成功 1 成功
     *                   "type" => { 类型
     *                          "no"=>"CRT02"
     *                           "name"=>"第三方充值"
     *                      }
     *                   "body" => null 失败原因
     *                   "typeNo" => "UCORDER05" 充值
     *                   "val2" => 0  优惠
     *
     *
     *                  提现
     *                  "no" => "CW2017053115432719237" 提现单号
     *                   "amount" => "200.000" 提现金额
     *                   "status" => array:2 [ 状态
     *                   "no" => "CW01"
     *                   "name" => "成功"
     *                   ]
     *                   "userid" => 262 用户id
     *                   "chkuserid" => 2 审核用户id
     *                   "bankid" => "6214830121885395" 用户银行卡后
     *                   "time" => "2017-05-31 15:43:27" 申请时间
     *                   "srcbankid" => "110925871910801" 系统银行卡号
     *                   "chktime" => "2017-05-31 15:44:49" 审核时间
     *                   "success" => 1 是否成功
     *                   "type" => array:2 [ 类型
     *                   "no" => "CWT01"
     *                   "name" => "普通"
     *                   ]
     *                   "rate" => "0.200" 提现费率
     *                   "fee" => "0.400" 手续费
     *                   "out" => "199.600" 实际到账金额
     *                   "body" => null 失败原因
     *                   "typeNo" => "UCORDER03" 提现
     *                   "val2" => 0 优惠
     *
     *
     *
     *
     *
     *      }
     *  }
     */
    public function run()
    {
        $no = $this->request->input('no');

        $data = new CashOrderData();
        $adapter = new CashOrderAdapter();

        $jobInfo = $data->getCashOrder($no);

        return $this->Success($jobInfo);
    }
}
