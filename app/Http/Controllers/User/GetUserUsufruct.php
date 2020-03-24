<?php

namespace App\Http\Controllers\User;

use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Item\ContractData;

class GetUserUsufruct extends Controller
{
    protected $validateArray=[
        "no"=>"required",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入现金单号!",
    ];

    /**
     *
     *
     * @api {post} login/project/getcashbillusufruct 查询收益权转让协议（账单处）
     * @apiName getcashbillusufruct
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} no 单号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : "UCO2017062719504572783",
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
     *              "sellUser" : { //甲方
     *                  "idno" : "4211********3816" //身份证号
     *                  "name" : "周涛" //名字
     *              }
     *              "buyUser" : { //乙方
     *                  "idno" : "4211********3816" //身份证号
     *                  "name" : "周涛" //名字
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

        $data = new ContractData();
        $res = $data->getCashBillUsufruct($no);

        $this->Success($res);
    }
}
