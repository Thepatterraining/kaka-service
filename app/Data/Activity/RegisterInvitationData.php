<?php
namespace App\Data\Activity;

use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\InvitationData;
use App\Data\Activity\ActivityRecordData;
use App\Data\Activity\InfoData;
use App\Data\Sys\ErrorData;
use App\Data\User\UserTypeData;

class RegisterInvitationData
{



    /***
     * Add the invitation record;
     *
     * @param userid the userid ;
     * @param invitecode the invite code;
     **/
    public function AddInviteRecord($userid, $inviteCode)
    {


        $codeFac = new InvitationCodeData();
        $recordFac = new InvitationData();
        $recordData = new ActivityRecordData();
        $infoData = new InfoData();
        $groupItemData = new GroupItemData();
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($userid);


        ///查找邀请码是否有效
        $codeItem = $codeFac->getByNo($inviteCode);
        if ($codeItem != null) {
            if ($codeItem->invite_count < $codeItem->invite_maxcount || $codeItem->invite_maxcount == 0) {
                $codeType = $codeItem->invite_type;
                if ($codeType == $codeFac::USER_CODE) {
                    $activityNo = $codeItem->invite_activity;
                    if (empty($activityNo)) {
                        $activityNo = $sysConfigs[UserTypeData::$USER_ACTIVITY_DEFAULT];
                    }
                } else {
                    $activityNo = $codeItem->invite_activity;
                }

                //查询已参加的活动
                $userCanActivity = $recordData->canActivity($activityNo, $userid);
                if ($userCanActivity !== true) {
                    return $userCanActivity;
                }

                $groupItemData = new GroupItemData();
                $groupItemInfo = $groupItemData->getGroupItem($activityNo);
                $userGroupNo = $groupItemInfo->group_no;
                
                //参加活动
                $infoData->addUserActivity($activityNo, $userid);
                

                ///查看是否有关联的活动
            
                
                ///加入邀请记录
                $recordFac->add($inviteCode, $codeItem->invite_user, $userid);

                //加入活动记录
                $recordData->add($userGroupNo, $activityNo, $userid);
                
                ///更新邀请数量
                $codeItem -> invite_count = $codeItem->invite_count + 1;

                $codeItem->save();
                return true;
            } else {
                return false;
            }
        }
    }
}
