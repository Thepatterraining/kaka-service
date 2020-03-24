<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class CashFeeData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\CashFee';

    protected $no = 'cash_withdrawal_feeno';

    const SUCCESS_STATUS = 'CWF01';
    const FAIL_STATUS = 'CWF02';

    /**
     * 增加提现手续费
     *
     * @param   $withdrawalNo 提现单据号
     * @param   $withdrawalRate 手续费率
     * @param   $fee 手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function add($withdrawalNo, $withdrawalRate, $fee, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $sysCashFeeNo = $docNo->Generate('WF');
        $model = $this->newitem();
        $model->cash_withdrawal_feeno = $sysCashFeeNo;
        $model->cash_withdrawal_feeamount = $fee;
        $model->cash_withdrawal_feestatus = 'CWF00';
        $model->cash_withdrawal_no = $withdrawalNo;
        $model->cash_withdrawal_feetime = $date;
        $model->cash_withdrawal_feetype = 'CWFT01';
        $model->cash_withdrawal_rate = $withdrawalRate;
        $this->create($model);
    }

    /**
     * 更新提现手续费状态
     *
     * @param   $withdrawalNo 提现单据号
     * @param   string                       $status  状态
     * @param   bool                         $success 是否成功
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveStatus($withdrawalNo, $status = self::SUCCESS_STATUS, $success = 1, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
    
        $where['cash_withdrawal_no'] = $withdrawalNo;
        $model = $this->find($where);
        $model->cash_withdrawal_feestatus = $status;
        $model->cash_withdrawal_feechktime = $date;
        $model->cash_withdrawal_feesuccess = $success;
        $this->save($model);
    }
}
