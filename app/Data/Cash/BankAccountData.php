<?php
namespace App\Data\Cash;

use App\Data\IDataFactory;
use App\Data\Sys\CashJournalData;

class BankAccountData extends IDatafactory
{

    protected $modelclass = 'App\Model\Cash\BankAccount';

    protected $no = 'account_no';

    
    const TYPE_STOCK_FUND = 'AC04';
    const TYPE_PLATFORM = 'AC05';
    const TYPE_ESCROW = 'AC06';

    const FLOW_TYPE_INSIDE = 'inside';
    const FLOW_TYPE_OUTSIDE = 'outside';

    /**
     * 增加银行卡在途余额
     *
     * @param   $desbankId 银行卡号
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCash($desbankId, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending + $amount;
        $model->account_pending = $pending;
        $model->account_change_time = $date;
        return $model->save();
    }

    /**
     * 更新这个类型下的卡余额
     *
     * @param   $desbankid 卡号
     * @param   $amount 在途金额
     * @param   $type 类型
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function saveTypePending($desbankId, $amount, $type, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $where['account_type'] = $type;
        // dump($where);
        $model = $this->findForUpdate($where);
        // dump($model);
        $pending = $model->account_pending + $amount;
        $model->account_pending = $pending;
        $model->account_change_time = $date;
        $model->save();

        $res['accountPending'] = $pending;
        $res['accountCash'] = $model->account_cash;
        return $res;
    }


    /**
     * 更新这个类型下的卡余额
     *
     * @param   $desbankid 卡号
     * @param   $amount 在途金额
     * @param   $type 类型
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function saveTypePendingLess($desbankId, $amount, $type, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $where['account_type'] = $type;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending - $amount;
        $model->account_pending = $pending;
        $model->account_change_time = $date;
        $model->save();

        $res['accountPending'] = $pending;
        $res['accountCash'] = $model->account_cash;
        return $res;
    }


    /**
     * 这个类型的账户可用减少 在途增加
     *
     * @param   $desbankid  卡号
     * @param   $pending 在途金额
     * @param   $_cash 可用金额
     * @param   $type 类型
     * @param   $date 时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveTypePendingCash($desbankid, $pending, $_cash, $type, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankid;
        $where['account_type'] = $type;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending + $pending;
        $cash = $model->account_cash - $_cash;
        $model->account_pending = $pending;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $model->save();

        $res['accountPending'] = $pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 这个类型的账户可用减少 在途增加
     *
     * @param   $desbankid  卡号
     * @param   $pending 在途金额
     * @param   $_cash 可用金额
     * @param   $type 类型
     * @param   $date 时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveNoTypePendingCash($desbankid, $pending, $_cash, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankid;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending + $pending;
        $cash = $model->account_cash - $_cash;
        $model->account_pending = $pending;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $model->save();

        $res['accountPending'] = $pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 这个类型的账户可用增加 在途减少
     *
     * @param   $desbankid  卡号
     * @param   $pending 在途金额
     * @param   $_cash 可用金额
     * @param   $type 类型
     * @param   $date 时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveTypeCashPending($desbankid, $pending, $_cash, $type, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankid;
        $where['account_type'] = $type;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending - $pending;
        $cash = $model->account_cash + $_cash;
        $model->account_pending = $pending;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $model->save();

        $res['accountPending'] = $pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 资金池账户表在途金额减少，余额增加
     *
     * @param   $rechargeInfo  充值表信息
     * @param   $amount
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCashPending($desbankid, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankid;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending - $amount;
        $cash = $model->account_cash + $amount;
        $model->account_pending = $pending;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        return $model->save();
    }

    /**
     * 减少银行卡在途金额
     *
     * @param   $desbankId 银行卡号
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePending($desbankId, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending - $amount;
        $model->account_pending = $pending;
        $model->account_change_time = $date;
        return $model->save();
    }

    /**
     * 银行卡在途平掉 余额减少
     *
     * @param   $desbankid 银行卡号
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePendingCash($desbankid, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankid;
        $model = $this->findForUpdate($where);
        $pending = $model->account_pending - $amount;
        $cash = $model->account_cash - $amount;
        $model->account_pending = $pending;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        return $model->save();
    }

    /**
     * 减少余额  在途不变
     *
     * @param   $desbankId 银行卡号
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCashShao($desbankId, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $model = $this->findForUpdate($where);
        $cash = $model->account_cash - $amount;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        return $model->save();
    }

    /**
     * 减少余额  在途不变
     *
     * @param   $desbankId 银行卡号
     * @param   $type 类型
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function outCash($desbankId, $type, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $where['account_type'] = $type;
        $model = $this->findForUpdate($where);
        $cash = $model->account_cash - $amount;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 减少余额  在途不变
     *
     * @param   $desbankId 银行卡号
     * @param   $type 类型
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function inCash($desbankId, $type, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $where['account_type'] = $type;
        $model = $this->findForUpdate($where);
        $cash = $model->account_cash + $amount;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 增加余额 在途不变
     *
     * @param   $desbankId 银行卡号
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCashduo($desbankId, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_no'] = $desbankId;
        $model = $this->findForUpdate($where);
        $cash = $model->account_cash + $amount;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        return $model->save();
    }

    /**
     * 增加银行账户
     *
     * @param   $bankid 银行卡号
     * @param   $name 户名
     * @param   $bankNo 行号
     * @param   $type 类型
     * @author  zhoutao
     * @version 0.1
     */
    public function add($bankid, $name, $bankNo, $type)
    {
        $model = $this->newitem();
        $model->account_no = $bankid;
        $model->account_name = $name;
        $model->account_bank = $bankNo;
        $model->account_type = $type;
        $this->create($model);
        return $model;
    }

    /**
     * 判断没有银行卡就添加
     *
     * @param   $sysBankid 银行卡号
     * @param   $bankType 类型
     * @author  zhoutao
     * @version 0.1
     */
    public function isEXistence($sysBankid, $bankType)
    {
        $name = '咔咔房链（北京）科技有限公司';
        $bankNo = 1;
        $cashBank = $this->getInfo($sysBankid, $bankType);
        if (empty($cashBank)) {
            //添加
            $this->add($sysBankid, $name, $bankNo, $bankType);
        }
    }

    public function getInfo($sysBankid, $bankType)
    {
        $where['account_type'] = $bankType;
        $where['account_no'] = $sysBankid;

        $model = $this->modelclass;
        $info = $model::where($where)->first();
        return $info;
    }

    /**
     * 查询系统银行卡号
     */
    public function getBankid($type)
    {
        $where['account_type'] = $type;
        $model = $this->modelclass;
        
        $info = $model::where($where)->first();
        if (empty($info)) {
            return null;
        }

        return $info->account_no;

    }

    /**
     * 查询被软删除的银行卡
     */
    public function getUserBankInfo($bankNo)
    {
        $modelclass =$this->modelclass;
        $where['account_no'] = $bankNo;
        return $modelclass::withTrashed()->where($where)->first();
    }

    /**
     * 减少余额 增加 在途
     *
     * @param  $bankType 账户类型
     * @param  $jobNo 流水关联单号
     * @param  $cash 余额减少金额
     * @param  $pending 在途增加金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.8.21
     */
    public function reduceCashIncreasePending($bankType,$jobNo,$cash,$pending, $type, $status,$date = null, $bankCard = '', $flowType = self::FLOW_TYPE_INSIDE)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        // $date = date('Y-m-d H:i:s');
        $where['account_type'] = $bankType;
        if (!empty($bankCard)) {
            $where['account_no'] = $bankCard;
        }
        $model = $this->modelclass;
        
        $info = $model::where($where)->first();

        if (empty($info)) {
            $this->isEXistence($bankCard, $bankType);
            $info = $model::where($where)->first();
        }

        if (empty($bankCard)) {
            $bankCard = $info->account_no;
        }

        $info->account_cash -= $cash;
        $info->account_pending += $pending;
        $info->account_change_time = $date;
        $this->save($info);

        //写入流水
        $sysCashAccountModel['accountPending'] = $info->account_pending;
        $sysCashAccountModel['accountCash'] = $info->account_cash;
        
        $sysCashJournalData = new CashJournalData;
        $sysCashJournalData->add('', $jobNo, $pending, $sysCashAccountModel, $type, $status, 0, $cash, $date, $bankCard);
    }

    /**
     * 减少余额
     *
     * @param  $bankType 账户类型
     * @param  $jobNo 流水关联单号
     * @param  $cash 余额减少金额
     * @param  $pending 在途增加金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @param  $bankCard 卡号
     * @author zhoutao
     * @date   2017.9.6
     */
    public function reduceCash($bankType,$jobNo,$cash, $type, $status,$date = null, $bankCard = '', $flowType = self::FLOW_TYPE_INSIDE)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        // $date = date('Y-m-d H:i:s');
        $where['account_type'] = $bankType;
        if (!empty($bankCard)) {
            $where['account_no'] = $bankCard;
        }
        $model = $this->modelclass;
        
        $info = $model::where($where)->first();

        if (empty($info)) {
            $this->isEXistence($bankCard, $bankType);
            $info = $model::where($where)->first();
        }

        if (empty($bankCard)) {
            $bankCard = $info->account_no;
        }

        $info->account_cash -= $cash;
        $info->account_change_time = $date;
        $this->save($info);

        //写入流水
        $sysCashAccountModel['accountPending'] = $info->account_pending;
        $sysCashAccountModel['accountCash'] = $info->account_cash;
        
        $sysCashJournalData = new CashJournalData;
        $sysCashJournalData->add('', $jobNo, 0, $sysCashAccountModel, $type, $status, 0, $cash, $date, $bankCard);
    }

    /**
     * 在途增加
     *
     * @param  $bankType 账户类型
     * @param  $jobNo 流水关联单号
     * @param  $pending 在途增加金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao 
     * @date   2017.8.21
     */
    public function increasePending($bankType,$jobNo,$pending,$type,$status,$date = null, $bankCard = '', $flowType = self::FLOW_TYPE_INSIDE)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $where['account_type'] = $bankType;
        if (!empty($bankCard)) {
            $where['account_no'] = $bankCard;
        }
        $model = $this->modelclass;
        
        $info = $model::where($where)->first();

        if (empty($info)) {
            $this->isEXistence($bankCard, $bankType);
            $info = $model::where($where)->first();
        }
        
        if (empty($bankCard)) {
            $bankCard = $info->account_no;
        }

        $info->account_pending += $pending;
        $info->account_change_time = $date;
        $this->save($info);

        //写入流水
        $sysCashAccountModel['accountPending'] = $info->account_pending;
        $sysCashAccountModel['accountCash'] = $info->account_cash;
        $sysCashJournalData = new CashJournalData;
        $sysCashJournalData->add('', $jobNo, $pending, $sysCashAccountModel, $type, $status, 0, 0, $date, $bankCard);
    }

    /**
     * 在途减少
     *
     * @param  $bankType 账户类型
     * @param  $jobNo 关联单号
     * @param  $pending 减少的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.8.21
     */
    public function reducePending($bankType,$jobNo,$pending,$type,$status,$date = null, $bankCard = '', $flowType = self::FLOW_TYPE_INSIDE)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        // $date = date('Y-m-d H:i:s');
        $where['account_type'] = $bankType;
        if (!empty($bankCard)) {
            $where['account_no'] = $bankCard;
        }
        $model = $this->modelclass;
        
        $info = $model::where($where)->first();

        if (empty($info)) {
            $this->isEXistence($bankCard, $bankType);
            $info = $model::where($where)->first();
        }

        if (empty($bankCard)) {
            $bankCard = $info->account_no;
        }

        $info->account_pending -= $pending;
        $info->account_change_time = $date;
        $this->save($info);

        //写入流水
        $sysCashAccountModel['accountPending'] = $info->account_pending;
        $sysCashAccountModel['accountCash'] = $info->account_cash;
        $sysCashJournalData = new CashJournalData;
        $sysCashJournalData->add('', $jobNo, -$pending, $sysCashAccountModel, $type, $status, 0, 0, $date, $bankCard);
    }

    /**
     * 在途减少，可用增加
     *
     * @param  $bankType 账户类型
     * @param  $jobNo 关联单号
     * @param  $cash 可用增加的金额
     * @param  $pending 在途减少的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * @date   2017.8.21
     */
    public function increaseCashReducePending($bankType,$jobNo,$cash,$pending,$type,$status,$date = null, $bankCard = '', $flowType = self::FLOW_TYPE_INSIDE)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        // $date = date('Y-m-d H:i:s');
        $where['account_type'] = $bankType;
        if (!empty($bankCard)) {
            $where['account_no'] = $bankCard;
        }
        $model = $this->modelclass;
        
        $info = $model::where($where)->first();

        if (empty($info)) {
            $this->isEXistence($bankCard, $bankType);
            $info = $model::where($where)->first();
        }

        if (empty($bankCard)) {
            $bankCard = $info->account_no;
        }

        $info->account_cash += $cash;
        $info->account_pending -= $pending;
        $info->account_change_time = $date;
        $this->save($info);

        //写入流水
        $sysCashAccountModel['accountPending'] = $info->account_pending;
        $sysCashAccountModel['accountCash'] = $info->account_cash;
        $sysCashJournalData = new CashJournalData;
        $sysCashJournalData->add('', $jobNo, -$pending, $sysCashAccountModel, $type, $status, $cash, 0, $date, $bankCard);
    }
}
