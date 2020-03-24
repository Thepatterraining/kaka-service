<?php

namespace App\Http\Controllers\User;

use App\Data\Cash\WithdrawalData;
use App\Data\User\BankAccountData;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\HttpLogic\BankLogic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetWithdrawalList extends Controller
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

    //查找提现信息
    /**
     *
     * @api {post} user/getwithdrawallist 查询提现列表
     * @apiName CashWithdrawals
     * @apiGroup Cash
     * @apiversion 0.0.1
     *
     *
     * @apiParam {number} pageIndex 页码
     * @apiParam {number} pageSize 每页数量
     *
     * @apiParamExample {json} Request-Example:
     *
     *  {
     *      pageIndex : 1,
     *      pageSize  : 10,
     *      filters  : {  查询条件 可选
     *
     *      }
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *          no : 单据号,
     *          amount : 提现金额,
     *          status : {
     *              no : "CW00" 状态
     *              name : "普通"
     *          }
     *          userid : 用户
     *          chkuserid : 审核人
     *          bankid : 银行名称
     *          time : 申请时间
     *          srcbankid : 系统卡号
     *          chktime : 审核时间
     *          success : 是否成功
     *          type : { 类型
     *              no : "CWT01"
     *              name : 普通
     *          }
     *          rate : 费率
     *          fee : 手续费
     *          out : 实际到账金额
     *          body : 失败原因
     *      }
     *  }
     */
    public function run()
    {
        $data = new WithdrawalData();
        $adapter = new WithdrawalAdapter();
        $resquest = $this->request->all();
        $resquest['filters']['userid'] = $this->session->userid;
        $where = $adapter->getFilers($resquest);
        $item = $data->whereIn($where, $resquest['pageSize'], $resquest['pageIndex']);
        $datafac = new BankAccountData();
        $bankAdapter = new UserBankCardAdapter();
        $bankfac = new BankLogic();
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            if (!empty($arr['bankid'])) {
                $arr['bankid'] = $datafac->getUserBankInfo($arr['bankid']);
                $arr['bankid'] = $bankAdapter->getDataContract($arr['bankid'], ['no','name','bank']);
                $arr['bankid'] = $bankfac->getBankName($arr['bankid']['bank']);
            }
            // $arr['amount'] = sprintf("%.2f",$arr['amount']);

            $res[] = $arr;
        }
        $item['items'] = $res;
        return $this->Success($item);
    }
}
