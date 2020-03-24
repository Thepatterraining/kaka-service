<?php
namespace App\Data\Auth;

use App\Data\IDataFactory;

class AuthItemData extends IDataFactory
{
    protected $modelclass = 'App\Model\Auth\AuthItem';

    /**
     * 写入权限子表
     *
     * @param $authid 权限id
     * @param $groupid 组id
     */
    public function add($authid, $groupid)
    {
        $model = $this->newitem();
        $model->auth_id = $authid;
        $model->group_id = $groupid;
        $this->create($model);
    }

    /**
     * 删除权限子表
     *
     * @param $authid 权限id
     * @param $groupid 组id
     */
    public function remove($authid,$groupid)
    {
        $where['auth_id'] = $authid;
        $where['group_id'] = $groupid;

        $model = $this->modelclass;
        $model::where($where)->delete();
    }

    /**
     * 查询管理组的这个权限
     *
     * @param $authid 权限id
     * @param $groupid 组id
     */
    public function getAuth($authid, $groupid)
    {
        $where['auth_id'] = $authid;
        $where['group_id'] = $groupid;

        $model = $this->modelclass;
        return $model::where($where)->first();
    }

    /**
     * 查询管理组的所有权限
     */
    public function getAuths($groupid)
    {
        $where['group_id'] = $groupid;

        $model = $this->modelclass;
        return $model::where($where)->get();
    }

}
