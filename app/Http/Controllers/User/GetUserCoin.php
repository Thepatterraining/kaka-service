<?php

namespace App\Http\Controllers\User;

use App\Data\Coin\FrozenData;
use App\Data\Item\FormulaData;
use App\Data\Project\ProjectInfoData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\Coin\FrozenAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserTypeData;
use App\Data\Sys\ErrorData;

class GetUserCoin extends Controller
{
    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型",
    ];

    /**
     * @api {post} login/user/getusercoin 获取代币详情
     * @apiName getusercoin
     * @apiGroup Coin
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     * @apiParam {string} coinType 代币类型
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : token
     *      coinType : 'KKC-BJ0001'
     *
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
     *              "cash" : 0, //可用的代币 份数
     *              "pending" : 0, //冻结的代币 份数
     *          }
     *  }
     */
    public function run()
    {
        //获取项目id
        $coinType = $this->request->input('coinType');

        $data = new CoinAccountData();
        $adapter = new CoinAccountAdapter();
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($this->session->userid);

        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);
        $scale = $projectInfo->project_scale;

        //解冻
        $forzenData = new FrozenData();
        $forzenAdapter = new FrozenAdapter();
        $forzenData->RelieveForzen();

        $res = [];
        $cash = $data->getUserCoinCash($coinType);
        $pending = $data->getUserCoinPending($coinType);

        $cash /= $scale;
        $pending /= $scale;

        $res['cash'] = $cash;
        $res['pending'] = $pending;

        return $this->Success($res);
    }
}
