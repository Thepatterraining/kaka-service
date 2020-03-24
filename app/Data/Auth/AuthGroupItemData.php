<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;

class AuthGroupItemData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\AuthGroupItem';

    /**
     * 添加用户组子表信息
     *
     * @param $groupid 用户组id
     * @param $userid 用户id
     */
    public function add($groupid, $userid)
    {
        $model = $this->newitem();
        $model->group_id = $groupid;
        $model->authuser_id = $userid;
        $this->save($model);
    }

    /**
     * 删除用户组子表信息
     *
     * @param $groupid 用户组id
     * @param $userid 用户id
     */
    public function del($groupid, $userid)
    {
        $where['group_id'] = $groupid;
        $where['authuser_id'] = $userid;

        $model = $this->modelclass;
        $model::where($where)->delete();
    }

    /**
     * 查询用户组下所有用户
     *
     * @param $groupid 用户组id
     */
    public function getUsers($groupid)
    {
        $where['group_id'] = $groupid;
        
        $model = $this->modelclass;
        return $model::where($where)->get();
    }

    /**
     * 查询这个用户组里面有没有这个用户
     *
     * @param $groupid 用户组id
     * @param $userid 用户id
     */
    public function getUser($groupid, $userid)
    {
        $where['group_id'] = $groupid;
        $where['authuser_id'] = $userid;

        $model = $this->modelclass;
        return $model::where($where)->first();
    }

    /**
     * 查询用户的所有用户组
     */
    public function getGroups($userid)
    {
        $where['authuser_id'] = $userid;
        
        $model = $this->modelclass;
        
        return $model::where($where)->get();
    }
    

    
}
