<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\ErrorData;
use App\Data\Activity\GroupItemData;
use App\Data\Activity\ActivityRecordData;
use App\Data\Activity\InvitationCodeData;
use App\Data\User\UserTypeData;

class ActivityRecordData extends IDatafactory
{

    protected $no = 'record_no';
    protected $modelclass = 'App\Model\Activity\Record';

    /**
     * 添加邀请记录
     *
     * @param   $groupNo 分组编号
     * @param   $activityNo 活动编号
     * @param   $userid 用户
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function add($groupNo, $activityNo, $userid)
    {
        $doc = new DocNoMaker();
        $no = $doc->Generate('AR');
        $model = $this->newitem();
        $model->record_no = $no;
        $model->record_group = $groupNo;
        $model->record_activity = $activityNo;
        $model->record_userid = $userid;
        return $this->create($model);
    }

    /**
     * 查询用户参加过哪些活动
     *
     * @param   $userid 用户
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserRecords($userid)
    {
        $where['record_userid'] = $userid;
        $model = $this->modelclass;
        $userInvitations = $model::where($where)->get();
        return $userInvitations;
    }

    /**
     * 查询用户是否可以参加这个活动
     *
     * @param   $activityNo 活动编号
     * @param   $userid 用户
     * @author  zhoutao
     * @version 0.1
     */
    public function canActivity($activityNo, $userid)
    {
        $groupItemData = new GroupItemData();
        $recordData = new ActivityRecordData();
        $groupItemInfo = $groupItemData->getGroupItem($activityNo);
        if ($groupItemInfo == null) {
            return false;
        }
        $userGroupNo = $groupItemInfo->group_no;

        $userInvitations = $this->getUserRecords($userid);
        if (!$userInvitations->isEmpty()) {
            foreach ($userInvitations as $userInvitation) {
                $groupNo = $userInvitation->record_group;
                
                if ($groupNo == $userGroupNo) {
                    return ErrorData::$ACTIVITY_UNIQUE_FIRST;
                }
            }
        }
     
        return true;
    }

    /**
     * 查询邀请码是否可用
     *
     * @param   $code 邀请码
     * @param   $userid 用户
     * @author  zhoutao
     * @version 0.1
     */
    public function canInvitation($code, $userid)
    {
        $codeFac = new InvitationCodeData();
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $activityCode = $codeFac->getByNo($code);
        if ($activityCode == null) {
            return false;
        }
        $count = $activityCode->invite_count;
        $maxCount = $activityCode->invite_maxcount;
 
        if ($maxCount > 0 &&  $count +1> $maxCount) {
            return ErrorData::$ACTIVITY_CODE_UNIQUE;
        }
        $activityNo = $activityCode->invite_activity;
        if (empty($activityNo)) {
            $activityNo = $sysConfigs[UserTypeData::$USER_ACTIVITY_DEFAULT];
        }
 
        $activityRes = $this->canActivity($activityNo, $userid);
        return $activityRes;
    }
}
