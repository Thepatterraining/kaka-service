<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class FeeData extends IDatafactory
{

    protected $no = 'coin_withdrawal_feeno';

    protected $modelclass = 'App\Model\Coin\Fee';

    /**
     * 增加手续费
     *
     * @param   $no 单据号
     * @param   $jobno 关联单据号 -提现单据号
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @param   $rate 手续费率
     * @param   $status 状态
     * @param   $type 类型
     * @author  zhoutao
     * @version 0.1
     */
    public function addFee($no, $jobno, $coinType, $amount, $rate, $status, $type, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->newitem();
        $model->coin_withdrawal_feeno = $no;
        $model->coin_withdrawal_no = $jobno;
        $model->coin_withdrawal_cointype = $coinType;
        $model->coin_withdrawal_feeamount = $amount;
        $model->coin_withdrawal_feestatus = $status;
        $model->coin_withdrawal_feetime = $date;
        $model->coin_withdrawal_feetype = $type;
        $model->coin_withdrawal_rate = $rate;
        return $model->save();
    }

    /**
     * 修改手续费表
     *
     * @param   $no 提现单据号
     * @param   string             $status  状态
     * @param   int                $success 是否成功
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveFee($no, $status = 'CWF01', $success = 1, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['coin_withdrawal_no'] = $no;
        $model = $this->findForUpdate($where);
        $model->coin_withdrawal_feestatus = $status;
        $model->coin_withdrawal_feechktime = $date;
        $model->coin_withdrawal_feesuccess = $success;
        return $model->save();
    }
}
