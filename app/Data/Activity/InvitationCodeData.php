<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\ErrorData;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;

class InvitationCodeData extends IDatafactory
{
    const STR_CODE  = "1234567890abcdefghijklmnopqrstuvwxyz";
    protected $no = 'invite_code';
    const USER_CODE = "INVC01";
    const ACT_CODE = "INVC02";

    protected $modelclass = 'App\Model\Activity\InvitationCode';

    /**
     * 修改邀请数量
     *
     * @param   $code 邀请码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.11
     */
    public function saveCount($code)
    {
        $model = $this->getByNo($code);
        $model->invite_count = $model->invite_count + 1;
        $res = $this->save($model);
        return $res;
    }

    /**
     * 添加邀请码
     *
     * @param  $activityNo
     * @param  $userid
     * @return mixed
     */
    public function add($activityNo, $userid)
    {
        $docNo = new DocNoMaker();
        $code = $docNo->getRandomString(8);
        $model = $this->newitem();
        $model->invite_code = $code;
        $model->invite_activity = $activityNo;
        $model->invite_user = $userid;
        $model->invite_count = 0;
        return $this->create($model);
    }

    /**
     * 添加邀请码
     *
     * @param  $activityNo
     * @param  $userid
     * @return mixed
     */
    public function addCode($activityNo, $userid, $maxCount, $type)
    {
        $docNo = new DocNoMaker();
        $code = $docNo->getRandomString(8);
        $model = $this->newitem();
        $model->invite_code = $code;
        $model->invite_activity = $activityNo;
        $model->invite_user = $userid;
        $model->invite_count = 0;
        $model->invite_maxcount = $maxCount;
        $model->invite_type = $type;
        return $this->create($model);
    }

    /**
     * 根据邀请码删除
     *
     * @param   $code 邀请码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function delCode($code)
    {
        $model = $this->newitem();
        $where['invite_code'] = $code;
        $res = $model->where($where)->delete();
        return $res;
    }

    private function generateCode()
    {
        $len = 8;
        $code = "";
        $result = "";
        for ($i =0; $i<$len; $i++) {
            $index = rand(0, 35);
            $result = $result . InvitationCodeData::STR_CODE[ $index];
        }
        return $result ;
    }

    /**
     * create invationcode of user ;
     * 生成用户用的邀请码
     *
     * @param   user_id
     * @author  geyunfei(geyunfei@kakamf.com)
     * @version 0.1
     */
    public function createCode($user_id, $activityNo = "")
    {
                
        $dbmodel = $this->modelclass;
        
        $code = $this->generateCode();
        $item = $this->newitem();
        while ($dbmodel::where('invite_code', $code)->count()>0) {
            $code = $this->generateCode();
        }
        $item->invite_code = $code;
        $item->invite_user = $user_id;
        $item->invite_count =0;
        $item->invite_maxcount = 0;
        $item->invite_type = InvitationCodeData::USER_CODE;
        $item->invite_activity = $activityNo;
        $item->save();
        return $code;
    }

    public function createActivityCode($activityNo, $maxcount = 1)
    {
        
        $dbmodel = $this->modelclass;
        $code = $this->generateCode();
        $item = $this->newitem();
        while ($dbmodel::where('invite_code', $code)->count()>0) {
               $code = $this->generateCode();
        }
        $item->invite_code = $code;
        $item->invite_count =0;
        $item->invite_maxcount = $maxcount;
        $item->invite_activity = $activityNo;
        $item->invite_type = InvitationCodeData::ACT_CODE;
        $item->save();
        return $code;
    }

    /**
     * 查询邀请码持有人
     *
     * @param  $code 邀请码
     * @author zhoutao
     */
    public function getCodeUser($code)
    {
        $info = $this->getByNo($code);
        if (!empty($info)) {
            if ($info->invite_user > 0) {
                return $info->invite_user;
            }
        }
        return null;
    }

    /**
     * 查询邀请码持有人信息
     *
     * @param  $code 邀请码
     * @author zhoutao
     */
    public function getCodeUserInfo($code)
    {
        $userData = new UserData;
        $userAdapter = new UserAdapter;
        $userid = $this->getCodeUser($code);
        if (empty($userid)) {
            return ErrorData::ACTIVITY_CODE_NOT_FOUND_USER;
        }
        $user = $userData->get($userid);
        if (empty($user)) {
            return ErrorData::$USER_NOT_FOUND;
        }
        $user = $userAdapter->getDataContract($user);
        return $user;
    }

}
