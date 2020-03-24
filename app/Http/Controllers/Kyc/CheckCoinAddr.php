<?php

namespace App\Http\Controllers\Kyc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Coin\CoinAddressInfoAdapter;
use App\Data\Coin\CoinAddressInfoData;
use App\Data\Sys\LockData;

/**
 * 地址认证
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.7
 */
class CheckCoinAddr extends Controller
{

    protected $validateArray=[
        "data.coinAddress"=>"required",
        "data.userIdno"=>"required",
        "data.userName"=>"required",
        "data.mobile"=>"required",
        "verify"=>"required",
        "data.userEmail"=>"required|email",
        "emailVerify"=>"required",
    ];

    protected $validateMsg = [
        "data.coinAddress.required"=>"请输入钱包地址",
        "data.userIdno.required"=>"请输入身份证号",
        "data.userName.required"=>"请输入身份证姓名",
        "data.mobile.required"=>"请输入手机号",
        "verify.required"=>"请输入短信验证码",
        "data.userEmail.required"=>"请输入邮箱",
        "data.userEmail.email"=>"邮箱格式不正确",
        "emailVerify.required"=>"请输入邮箱验证码",
    ];


    /**
     * @api {post} token/auth/checkCoinAddr 验证用户地址
     * @apiName checkCoinAddr
     * @apiGroup kyc
     * @apiVersion 0.0.1
     *
     * @apiParam {string} verify 短信验证码
     * @apiParam {string} emailVerify 邮箱验证码
     * @apiParam {string} data.coinAddress 钱包地址
     * @apiParam {string} data.userIdno 身份证号
     * @apiParam {string} data.userName 身份证姓名
     * @apiParam {string} data.mobile 手机号
     * @apiParam {string} data.userEmail 邮箱
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      verify : 1234,
     *      emailVerify  : 1234,
     *      data : {
     *          coinAddress : 'addr',
     *          userIdno : '421126*************',
     *          userName : '张三',
     *          mobile : 132*******,
     *          userEmail : "kaka@kaka.com"
     *      }
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     * {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : null
     * }
     */
    public function run()
    {
        $request = $this->request->all();
        $idno = $this->request->input("data.userIdno");
        $name = $this->request->input("data.userName");
        $mobile = $this->request->input("data.mobile");
        $addr = $this->request->input("data.coinAddress");

        $userData = new UserData;
        if ($userData->tongDunApi($name, $idno) === false) {
            return $this->Error(ErrorData::$USER_IDNO_ERROR);
        }

        $lk = new LockData;
        $key = 'coinAddr';
        $lk->lock($key);

        $coinAddrData = new CoinAddressInfoData;
        $coinAddrAdapter = new CoinAddressInfoAdapter;

        $info = $coinAddrData->getByKey(CoinAddressInfoData::COL_IDNO, $idno);
        if (!empty($info)) {
            return $this->Error(ErrorData::COINADDR_USERIDNO_REQUIRED);
        }

        $info = $coinAddrData->getByKey(CoinAddressInfoData::COL_NAME, $name);
        if (!empty($info)) {
            return $this->Error(ErrorData::COINADDR_USERNAME_REQUIRED);
        }

        $info = $coinAddrData->getByKey(CoinAddressInfoData::COL_MOBILE, $mobile);
        if (!empty($info)) {
            return $this->Error(ErrorData::COINADDR_MOBILE_REQUIRED);
        }

        $info = $coinAddrData->getByKey(CoinAddressInfoData::COL_ADDR, $addr);
        if (!empty($info)) {
            return $this->Error(ErrorData::COINADDR_ADDR_REQUIRED);
        }

        $info = $coinAddrAdapter->getData($this->request);
        $info['status'] = CoinAddressInfoData::APPLY_STATUS;
        $model = $coinAddrData->newitem();
        $coinAddrAdapter->saveToModel(false, $info, $model);
        $coinAddrData->create($model);
        $lk->unlock($key);        
        return $this->Success();
    }
}
