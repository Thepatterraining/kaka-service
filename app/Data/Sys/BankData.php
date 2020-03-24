<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class BankData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;
    
    protected $modelclass = 'App\Model\Sys\Bank';

    public function getByName($bankname, $banktype)
    {
    }

    /**
     * 查找银行信息
     *
     * @param   $bankname 银行名称
     * @param   $banktype 银行类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getBank($bankname, $banktype)
    {
        $where['bank_name'] = $bankname;
        $where['bank_type'] = $banktype;
        return $this->find($where);
    }

    /**
     * 添加银行信息
     *
     * @param   $bankname 银行名称
     * @param   $banktype 银行类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addBank($bankname, $banktype)
    {
        $model = $this->newitem();
        $model->bank_type = $banktype;
        $model->bank_name = $bankname;
        return $this->create($model);
    }

    /**
     * 查询该银行下的所有支行
     *
     * @param   $bankNo 银行
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function getFinanceBanks($bankNo)
    {
        $where['bank_no'] = $bankNo;
        $model = $this->newitem();
        $model->where($where)->get();
    }

    /**
     * 修改支行的银行
     *
     * @param   $id 支行id
     * @param   $bankNo 银行
     * @version 0.1
     * @author  zhoutao
     * @date    2017.5.4
     */
    public function saveBank($id, $bankNo)
    {
        $bankInfo = $this->get($id);
        $bankInfo->bank_no = $bankNo;
        $this->save($bankInfo);
    }
    
    /**
     * 添加银行信息
     *
     * @param   $bankname 银行名称
     * @param   $bankNo 银行号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addBranchBank($bankname, $bankNo)
    {
        $model = $this->newitem();
        $model->bank_no = $bankNo;
        $model->bank_name = $bankname;
        return $this->create($model);
    }

    /**
     * 根据银行号 查询一个支行
     *
     * @param   $bankNo 银行号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function getFinanceBank($bankNo)
    {
        $model = $this->newitem();
        $where['bank_no'] = $bankNo;
        $bankInfo = $model->where($where)->first();
        return $bankInfo;
    }

    /**
     * 根据银行号和支行名称 查询一个支行
     *
     * @param   $bankNo 银行号
     * @param   $branchName 支行名称
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function getFinanceBranchBank($bankNo, $branchName)
    {
        $model = $this->newitem();
        $where['bank_no'] = $bankNo;
        $where['bank_name'] = $branchName;
        $bankInfo = $model->where($where)->first();
        return $bankInfo;
    }
}
