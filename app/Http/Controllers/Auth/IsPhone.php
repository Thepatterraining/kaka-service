<?php

namespace App\Http\Controllers\Auth;

use App\Data\Activity\InfoData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\ActivityRecordData;

class IsPhone extends Controller
{
    protected $validateArray=[
        "code"=>"required",
    ];

    protected $validateMsg = [
        "code.required"=>"请输入邀请码!",
    ];


    /**
     * 验证邀请码
     *
     * @param   phone 邀请码
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $code = $this->request->input('code');
        
        $infoData = new InfoData();
        $datafac = new UserData();

        //判断邀请码是否正确
        $recordData = new ActivityRecordData();
        $userCanActivity = $recordData->canInvitation($code, $this->session->userid);
        if ($userCanActivity === false) {
            return $this->Success(false);
        }
        if ($userCanActivity !== true) {
            return $this->Success(false);
        }

        return $this->Success(true);
    }
}
