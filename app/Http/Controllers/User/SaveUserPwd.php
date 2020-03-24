<?php

namespace App\Http\Controllers\User;

use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Data\Sys\ErrorData;

class SaveUserPwd extends Controller
{
    protected $validateArray=[
        "phone"=>"required",
        "pwd"=>"required|pwd",
    ];

    protected $validateMsg = [
        "phone.required"=>"请输入手机号",
        "pwd.required"=>"请输入登陆密码",
        "pwd.alpha_dash"=>"登陆密码只能输入字母和数字，以及破折号和下划线",
    ];

    /**
     * @api {post} auth/savepwd 忘记登陆密码
     * @apiName ForgetUserPwd
     * @apiGroup User
     * @apiversion 0.0.1
     *
     * @apiParam {string} phone 手机号
     * @apiParam {string} pwd 新密码
     * @apiParam {string} verify  手机验证码
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      phone   : '13898765432',
     *      pwd     : '123qwe' ,
     *      verify  : '564789'
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
     *      data : true
     *
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $phone = $request['phone'];
        $pwd = $request['pwd'];
        $data = new UserData();
        $userInfo = $data->getUser($phone);

        if (empty($userInfo)) {
            return $this->Error(ErrorData::$USER_NOT_FOUND);
        }

        $pwdRes = $data->checkPwd($userInfo, $pwd);
        if ($pwdRes === true) {
            return $this->Error(ErrorData::$USER_PWD_UNIQUE);
        }

        //支付密码不能和登陆密码一样
        if ($data->checkPay($phone, $pwd)) {
            return $this->Error(ErrorData::$CHECK_PWD_PAY);
        }
        

        $res = $data->savePwd($pwd, $phone);
        if ($res === false) {
            return $this->Error(ErrorData::$SAVE_FALSE);
        }
        $this->Success($res);
    }
}
