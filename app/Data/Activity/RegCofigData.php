<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;

class RegCofigData extends IDatafactory
{
    protected $no = 'invite_usertype';

    protected $modelclass = 'App\Model\Activity\Regcofig';

    /**
     * 根据用户类型查询活动编号
     *
     * @param   $userType
     * @return  mixed
     * @authro  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function getInfo($userType)
    {
        $model = $this->newitem();
        $where['invite_usertype'] = $userType;
        $info = $model->where($where)->first();
        return $info;
    }

    /**
     * 删除配置
     *
     * @param   $userType 用户类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function delConfig($userType)
    {
        $model = $this->newitem();
        $where['invite_usertype'] = $userType;
        $res = $model->where($where)->delete();
        return $res;
    }
}
