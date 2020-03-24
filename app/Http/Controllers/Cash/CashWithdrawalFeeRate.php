<?php

namespace App\Http\Controllers\Cash;

use App\Data\User\UserData;
use App\Data\User\CashAccountData;
use App\Data\Utils\DocMD5Maker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Utils\DocNoMaker;
use App\Data\User\UserTypeData;

class CashWithdrawalFeeRate extends Controller
{

    /**
     * @api {post} cash/withdrawal 现金提现手续费率
     * @apiName CashWithdrawalFee
     * @apiGroup Cash
     * @apiversion 0.0.1
     *
     * @apiParam {string} accessToken token
     *
     * @apiParamExample {json} Request-Example:
     *
     *  {
     *      accessToken : token,
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {string} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : '0.002'  提现手续费
     *  }
     */
    public function run()
    {
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $withFeeRate = array_get($sysConfigs, UserTypeData::$CASH_WITHDRAWAL_FEE_RATE);
        $this->Success($withFeeRate);
    }
}
