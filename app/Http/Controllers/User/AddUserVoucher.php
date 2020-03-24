<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use App\Data\Activity\InfoData;
use App\Data\User\UserData;
use App\Data\Activity\ActivityRecordData;
use App\Data\Activity\RegisterInvitationData;

class AddUserVoucher extends Controller
{

    protected $validateArray=[
        "activityCode"=>"required",
    ];

    protected $validateMsg = [
        "activityCode.required"=>"请输入兑换码",
    ];

    /**
     * 优惠券兑换
     *
     * @param   $activityCode 兑换码
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $code = $this->request->input('activityCode');
        
        $infoData = new InfoData();
        $datafac = new UserData();
        $regInvData = new RegisterInvitationData();

        //判断邀请码是否正确
        $recordData = new ActivityRecordData();
        $userCanActivity = $recordData->canInvitation($code, $this->session->userid);
        if ($userCanActivity === false) {
            // return $this->Error(ErrorData::$ACTIVITY_CODE_ERROR);
        }
        if ($userCanActivity !== true) {
            // return $this->Error($userCanActivity);
        }

        $userid = $this->session->userid;

        //开始执行发券
        $res = $regInvData->AddInviteRecord($userid, $code);
        if ($res === false) {
            return $this->Error(ErrorData::$ACTIVITY_CODE_ERROR);
        }
        

        return $this->Success();
    }
}
