<?php

namespace App\Http\Controllers\User;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\InvitationData;
use App\Data\Activity\RegCofigData;
use App\Data\Activity\RegVoucherData;
use App\Data\Sys\ErrorData;
use App\Data\User\CashAccountData;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Adapter\User\UserAdapter;
use App\Data\User\UserData;
use Illuminate\Support\Facades\DB;
use App\Data\Auth\AccessToken;

class RegUser extends Controller
{


    protected $validateArray=array(
        "pwd"=>"required|min:6|pwd",
        "paypwd"=>"required|min:6|paypwd",
        "data.loginid"=>"required",
        "data.nickname"=>"required",
        "data.mobile"=>"required|unique:sys_user,user_mobile",
        "data.name"=>"required",
        "data.idno"=>"required|unique:sys_user,user_idno|idno",
    );

    protected $validateMsg = [
        "pwd.required"=>"请输入登陆密码!",
        "pwd.min"=>"登陆密码最小6位!",
        "paypwd.required"=>"请输入交易密码!",
        "paypwd.min"=>"交易密码最小6位!",
        "paypwd.alpha_num"=>"交易密码必须是字母或者数字!",
        "data.loginid.required"=>"请输入登陆名!",
        "data.nickname.required"=>"请输入昵称！",
        "data.mobile.required"=>"请输入手机号！",
        "data.mobile.unique"=>"该手机号已注册！",
        "data.name.required"=>"请输入真实姓名!",
        "data.idno.required"=>"请输入合法的身份证号码！",
        "data.idno.unique"=>"该身份证号码已注册！",
    ];

    /**
     * 注册
     *
     * @author  zhoutao
     * @version 0.2
     * 增加了用户的现金账户
     */
    protected function run()
    {

        $adapter = new UserAdapter();
        $datafac = new UserData();
        $activiData = new RegVoucherData();
        $data = new InvitationData();
        $infoData = new InfoData();
        $invitationData = new InvitationCodeData();
        $regInfo = $adapter ->getData($this->request);
        $regInfo["status"]="US01";
        $pwd = $this->request->input("pwd");
        $paypwd = $this->request->input("paypwd");
        $code = $this->request->input('code');
        $phone = $this->request->input('data.mobile');


        //检查用户已注册，返回错误
        $user = $datafac->getUser($phone);
        if (!empty($user)) {
            return $this->Error(ErrorData::$USER_REQUIRED);
        }

        //查询实名是否正确
        $name = $this->request->input('data.name');
        $idno = $this->request->input('data.idno');
        $idnoCheck = $datafac->tongDunApi($name, $idno);
        if ($idnoCheck === false) {
            return $this->Error(ErrorData::$USER_IDNO_ERROR);
        }

        //判断邀请码是否正确
        $userType = $datafac->getCode($code);
        $activityNo = '';
        $codeRes = '';
        if ($userType != null) {
            //查询邀请注册设置表，拿到活动编号
            $regcofigData = new RegCofigData();
            $regcofigInfo = $regcofigData->getInfo($userType);
            if ($regcofigInfo != null) {
                $activityNo = $regcofigInfo->invite_activitycode;
            }
        } else {
            //查邀请码是否为活动邀请码
            $activityInfo = $infoData->getCodeInfo($code);

            if ($activityInfo != null) {
                $activityNo = $activityInfo->activity_no;
            } else {
                //查邀请码是否为活动邀请码 activity_invitationcode
                $invitation = $invitationData->getByNo($code);
                if ($invitation != null) {
                    $codeRes = 'INVITATION';
                    $activityNo = $invitation->invite_activity;
                }
            }
        }

        if (empty($activityNo)) {
            return $this->Error(ErrorData::$ACTIVITY_CODE_ERROR);
        }

        //开始注册
        $usermodel = $datafac->newitem();

        $adapter->saveToModel(false, $regInfo, $usermodel);

        $userid = $datafac->regUser($usermodel, $pwd, $paypwd);


        //开始执行发券
        $infoData->addUserActivity($activityNo, $userid);
        if ($codeRes == 'INVITATION') {
            //更改数量
            $res = $invitationData->saveCount($code);
        }

        $this->Success($userid);
    }
}
