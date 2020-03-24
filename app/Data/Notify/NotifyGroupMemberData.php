<?php
namespace App\Data\Notify;

use App\Data\IDataFactory;
use App\Data\Auth\UserData;

class NotifyGroupMemberData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Notify\NotifyGroupMembers';


    /**
     * 查询所有通道信息
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getNotifyGroupMember()
    {
        $model = $this->modelclass;
        return $model::get();
    }

    public function getClassName($id)
    {
        $groupInfo = $this->get($id);
        if (empty($groupInfo)) {
            return null;
        }
        return $groupInfo->group_name;
    }

    public function addNotifyGroupMember($groupId,$authUserId,$authUserName,$authUserEmail,$authUserMobile,$authUserOpenId=null)
    {
        $item= $this->newitem();
        $item->group_id=$groupId;
        $item->authuser_id=$authUserId;
        $item->authuser_name=$authUserName;
        $item->authuser_email=$authUserEmail;
        $item->authuser_mobile=$authUserMobile;
        $item->authuser_openid=$authUserOpenId;
        $this->create($item);
        return $item;
    }

    public function getClassByGroupId($groupId)
    {
        $model=$this->newitem();
        $groupInfo = $model->where('group_id', $groupId)->first();
        if (empty($groupInfo)) {
            return null;
        }
        return $groupInfo;
    }

    public function saveNotifyGroupMember($item,$authUserId)
    {
        $groupData=new NotifyGroupData();
        $groupModel=$groupData->newitem();

        $userData=new UserData();
        $userModel=$userData->newitem();
        $userInfo=$groupModel->where('id', $authUserId)->first();
        if(empty($userInfo)) {
            return $this->error(801001);
        }
        
        $item->authuser_id=$authUserId;
        $item->authuser_name=$userInfo->auth_name;
        $item->authuser_email=$userInfo->auth_email;
        $item->authuser_mobile=$userInfo->auth_mobile;
        $item->authuser_openid=null;
        $model->save($item);
        return $item;
    }

    public function getNotifyMembers($groups)
    {
        $model=$this->newitem();
        $res=array();
        $tmpSave=array();
        foreach($groups as $value){
            $tmp=$model->where('group_id', $value->notify_groupid)->get();
            foreach($tmp as $authUser)
            {
                // dump($authUser->authuser_id);
                // dump($tmpSave);
                if(!in_array($authUser->authuser_id, $tmpSave)) {
                    $tmpSave[]=$authUser->authuser_id;
                    $res[]=$authUser;
                }
            }
        }
        return $res;
    }

    public function getInfo($groupId,$authUserId)
    {
        $model=$this->newitem();
        $result=$model->where('group_id', $groupId)->where('authuser_id', $authUserId)->first();
        return $result;
    }

    public function getUserByGroup($groupId)
    {
        $model=$this->newitem();
        $result=$model->where('group_id', $groupId)->get();
        return $result;
    }

    public function getUserByItem($item)
    {
        $model=$this->newitem();
        $result=array();
        foreach($item as $value)
        {
            $res=where('group_id', $value)->get();
            if($res['items']!=null) {
                foreach($res as $user)
                {
                    if(!in_array($user, $result)) {
                        $result[]=$user;
                    }
                }
            }
        }
        return $result;
    }

    public function deleteMember($groupId,$authUserId)
    {
        $model=$this->newitem();
        $result=$model->where('group_id', $groupId)->where('authuser_id', $authUserId)->delete();
    }
}
