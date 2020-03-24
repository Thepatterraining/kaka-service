<?php
namespace App\Data\User;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\RegVoucherData;
use App\Data\Sys\ConfigData;
use App\Model\User\User;
use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\User\CashAccountData;
use App\Data\Auth\AccessToken;

/**
 * user operation
 *
 * @author  geyunfei (geyunfei@kakamf.com)
 * @version 0.1
 */

class UserVpData extends IDatafactory
{

    protected $modelclass = 'App\Model\User\UserVp';

    /**
     * 查询vp用户
     *
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function getUser($userid)
    {
        $model = $this->modelclass;
        $where['user_id'] = $userid;
        return $model::where($where)->first();
    }

    /**
     * 根据代币查vp用户
     *
     * @param   $userid 用户id
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserWhereCoinType($userid, $coinType)
    {
        $model = $this->modelclass;
        $where['user_id'] = $userid;
        $where['coin_type'] = $coinType;
        return $model::where($where)->first();
    }

    /**
     * @param $userid 用户id
     * @author zhoutao
     * @version 0.1
     */
    public function add($userid, $coinType)
    {
        $model = $this->newitem();
        $model->user_id = $userid;
        $model->coin_type = $coinType;
        $this->create($model);
    }

    /**
     * 修改成有效
     *
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function saveEnable($userid, $coinType)
    {
        $model = $this->getUserWhereCoinType($userid, $coinType);
        $model->enable = 1;
        $this->save($model);
    }

    /**
     * 判断是否是有效vp
     *
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function isEnable($userid)
    {
        $info = $this->getUser($userid);
        if (empty($info)) {
            return false;
        }
        if (!$info->enable) {
            return false;
        }
        if (!$info->enable_product) {
            return false;
        }
        return true;
    }
}
