<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Item\ContractData;

class GetItemUsufruct extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:sell,TS00,TS01",
        "count"=>"required",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入卖单编号!",
        "count.required"=>"请输入购买数量!",
    ];

    /**
     *
     *
     * @api {post} login/project/getusufruct 查询收益权转让协议（购买时候）
     * @apiName getusufruct
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} no 产品号
     * @apiParam {string} count 购买数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : "UCO2017062719504572783",
     *      count : "20"
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
     *              "contractNo" : "KK201706270001S000001" //合同号
     *              "amount" : "1800.00" //合同金额
     *              "usufruct" : "0.000197824" //转让比例
     *              "sellCashFeeRate" : "0.000" //费率
     *              "sellUser" : { //卖方
     *                  "idno" : "4211********3816" //身份证号
     *                  "name" : "周涛" //名字
     *                  "mobile" : "132******" //手机号
     *              }
     *              "buyUser" : { //买方
     *                  "idno" : "4211********3816" //身份证号
     *                  "name" : "周涛" //名字
     *                  "mobile" : "132******" //手机号
     *              }
     *              "platform" : { //丙方
     *                  "companyNo" : "911************ACQ0XK" //企业号
     *                  "companyName" : "咔咔房链（北京）科技有限公司" //企业名称
     *                  "companyAgent" : "" //法人
     *                  "companySign" : "/upload/contract/gongzhang_kaka.png" //章
     *              }
     *              "partner" : { //丁方
     *                  "fourthNo" : "911************ACQ0XK" //企业号
     *                  "companyName" : "咔咔房链（北京）科技有限公司" //企业名称
     *                  "fourthAgent" : "" //法人
     *                  "companySign" : "/upload/contract/gongzhang_kaka.png" //章
     *              }
     *              
     *      }
     */
    public function run()
    {
        $no = $this->request->input('no');
        $count = $this->request->input('count');

        $data = new ContractData();
        $res = $data->getUsufruct($no, $count);

        $this->Success($res);
    }
}
