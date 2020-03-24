<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Data\User\UserData;

class BankAccountData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\User\BankAccount';

    protected $no = 'account_no';
 
    /**
     * 添加用户银行卡
     *
     * @param   $bankno 银行卡号
     * @param   $username 用户姓名
     * @param   $bankId 支行id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addUserBank($bankno, $username, $bankId)
    {

        $udata = new UserData();
        $user = $udata -> get($this->session->userid);
        $model = $this->newitem();
        $model->account_no = $bankno;
 
        $model->account_name = $user->user_name;
        $model->account_bank = $bankId;
        $model->account_userid = $this->session->userid;
         $this->create($model);
         return $model;
    }

    /**
     * 添加用户银行卡
     */
    public function add($bankno, $username, $bankId, $phone)
    {
         $udata = new UserData();
        $user = $udata -> get($this->session->userid);
        $model = $this->newitem();
        $model->account_no = $bankno;
 
        $model->account_name = $user->user_name;
        $model->account_bank = $bankId;
        $model->account_userid = $this->session->userid;
        $model->account_mobile = $phone;
         $this->create($model);
         return $model;
    }

    /**
     * 查询用户列表
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserBankList()
    {

        $modelclass =$this->modelclass;
        return $modelclass::where('account_userid', $this->session->userid)->get();
    }

    /**
     * 查询用户有手机号的银行卡
     */
    public function getUserBankCards()
    {
        $modelclass =$this->modelclass;
        return $modelclass::where('account_userid', $this->session->userid)->where('account_mobile', '!=', '')->get();
    }

    /**
     * 删除用户银行卡
     *
     * @param   $bankid 银行卡号
     * @author  zhoutao
     * @version 0.1
     */
    public function delBank($bankid)
    {
        $model = $this->modelclass;
        $where['account_no'] = $bankid;
        $where['account_userid'] = $this->session->userid;
        return $model::where($where)->delete();
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
     * 查询银行卡
     */
    public function getUserBank($bankNo)
    {
        $modelclass =$this->modelclass;
        $where['account_no'] = $bankNo;
        $where['account_userid'] = $this->session->userid;
        return $modelclass::where($where)->first();
    }

    /**
     * 查询登陆用户的银行卡数量
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     * 
     * 增加手机号不为空的查询条件
     * @author  zhoutao
     * @date    2017.10.17
     */
    public function getUserBankCount()
    {
        $model = $this->modelclass;
        $count = $model::where('account_userid', $this->session->userid)->where('account_mobile', '!=', '')->count();
        return $count;
    }

    /**
     * 根据银行号查询用户银行卡信息
     *
     * @param   $bankNo 银行号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function getFinanceBanks($bankNo)
    {
        $modelclass =$this->modelclass;
        return $modelclass::where('account_bank', $bankNo)->get();
    }

    /**
     * 修改该银行卡号的银行
     *
     * @param   $accountNo 银行卡号
     * @param   $bankno 银行号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function saveBank($accountNo, $bankNo)
    {
        $userBankInfo = $this->getByNo($accountNo);
        $userBankInfo->account_bank = $bankNo;
        $this->save($userBankInfo);
    }
    /*
     * 更新用户银行卡的支行
     * @param $bankid 银行卡号
     * @param $bankNo 支行id
     * @author zhoutao
     * @version 0.1
     */
    public function saveBranchBank($bankid, $bankNo, $name)
    {
        $bankInfo = $this->getByNo($bankid);
        $bankInfo->account_bank = $bankNo;
        $bankInfo->account_name = $name;
        $this->save($bankInfo);
    }

    /*
     * 更新用户银行卡的支行
     * @param $bankid 银行卡号
     * @param $bankNo 支行id
     * @author zhoutao
     * @version 0.1
     */
    public function saveUserBranchBank($bankid, $bankNo, $name)
    {
        $bankInfo = $this->getUserBankInfo($bankid);
        $bankInfo->account_bank = $bankNo;
        $bankInfo->account_name = $name;
        $this->save($bankInfo);
    }

    /**
     * 更新用户银行卡的手机号
     *
     * @param  $bankCard 银行卡号
     * @param  $mobile 手机号
     * @author zhoutao
     */
    public function saveMobile($bankCard, $mobile)
    {
        $bankInfo = $this->getUserBank($bankCard);
        $bankInfo->account_mobile = $mobile;
        $this->save($bankInfo);
    }

    /**
     * 查询预留手机号
     */
    public function getMobile($bankCard)
    {
        // $bankInfo = $this->getByNo($bankCard);
        $bankInfo=$this->newitem()->where('account_no', $bankCard)->first();
        if (empty($bankInfo)) {
            return null;
        }
        return $bankInfo->account_mobile;
    }

    /**
     * 更新用户userid
     *
     * @param $bankCard 银行卡号
     */
    public function saveUserid($bankCard)
    {
        $bankInfo = $this->getByNo($bankCard);
        $bankInfo->account_userid = $this->session->userid;
        $this->save($bankInfo);
    }

    /**
     * 更新用户姓名
     *
     * @param $bankCard 银行卡号
     * @param $name 姓名
     */
    public function saveUserName($bankCard, $name)
    {
        $bankInfo = $this->getUserBank($bankCard);
        $bankInfo->account_name = $name;
        $this->save($bankInfo);
    }
}
