<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class RechageData extends IDatafactory
{

    protected $no = 'coin_recharge_no';

    protected $modelclass = 'App\Model\Coin\Rechage';

    const APPLY_STATUS = 'OR00';
    const SUCCESS_STATUS = 'OR01';

    const SYS_RECHARGE_TYPE = 'ORT04';

    /**
     * 代币充值表添加数据
     *
     * @param   $no 单据号
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @param   $userid 用户id
     * @param   $address 钱包地址
     * @param   $type 类型
     * @param   string                $status 状态
     * @author  zhoutao
     * @version 0.1
     */
    public function addRecharge($no, $coinType, $amount, $userid, $address, $type, $status = 'CR00', $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->newitem();
        $model->coin_recharge_no = $no;
        $model->coin_recharge_cointype = $coinType;
        $model->coin_recharge_amount = $amount;
        $model->coin_recharge_status = $status;
        $model->coin_recharge_userid = $userid;
        $model->coin_recharge_time = $date;
        $model->coin_recharge_address = $address;
        $model->coin_recharge_type = $type;
        return $model->save();
    }


    /**
     * 查询
     *
     * @param   $no 单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 去掉锁
     * @author  zhoutao
     * @date    2017.11.9
     */
    public function getRecharge($no)
    {
        $where['coin_recharge_no'] = $no;
        return $this->find($where);
    }

    /**
     * 更新充值表状态
     *
     * @param  $no 单据号
     * @param  $status 状态
     * @param  $success 是否有效
     * @return mixed
     */
    public function saveRecharge($no, $status, $success = 1, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getRecharge($no);
        $model->coin_recharge_success = $success;
        $model->coin_recharge_chkuserid = $this->session->userid;
        $model->coin_recharge_chktime = $date;
        $model->coin_recharge_status = $status;
        return $model->save();
    }
}
