<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;

class AuthGroupData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\AuthGroup';

    /**
     * 添加用户到用户组
     *
     * @param $groupid 用户组id
     * @param $userid 用户id
     */
    public function addMembers($groupid, $userid)
    {
        $authGroupItemData = new AuthGroupItemData;
        $authGroupItemData->add($groupid, $userid);
    }

    /**
     * 删除用户到用户组
     *
     * @param $groupid 用户组id
     * @param $userid 用户id
     */
    public function removeMembers($groupid, $userid)
    {
        $authGroupItemData = new AuthGroupItemData;
        $authGroupItemData->del($groupid, $userid);
    }

    /**
     * 查询用户组下所有用户
     *
     * @param $groupid 用户组id
     */
    public function getMembers($groupid)
    {
        $authGroupItemData = new AuthGroupItemData;
        return $authGroupItemData->getUsers($groupid);
    }

    
}
