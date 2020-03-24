<?php
namespace App\Data\Cash;

use App\Data\IDataFactory;
use App\Data\User\BankAccountData as UserBankAccountData;
use App\Data\Sys\BankData;
use App\Data\User\UserData;
use App\Data\Sys\LockData;
use App\Data\API\Payment\PaymentServiceFactory ;
class FinanceBankData extends IDatafactory
{

    protected $modelclass = 'App\Model\Cash\FinanceBank';

    protected $no = 'bank_no';

    /**
     * 查询已审核的银行
     *
     * @param   $no 银行号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function getCehckBank($no)
    {
        $where['bank_no'] = $no;
        $where['bank_ischeck'] = 1;
        $model = $this->newitem();
        $checkBank = $model->where($where)->first();
        return $checkBank;
    }

    /**
     * 查询已审核的银行列表
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.5
     */
    public function getCehckBanks()
    {
        $where['bank_ischeck'] = 1;
        $model = $this->newitem();
        $checkBanks = $model->where($where)->get();
        return $checkBanks;
    }

    /**
     * 审核银行
     *
     * @param   $bankNo 银行号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function checkBank($bankNo)
    {
        $bankInfo = $this->getByNo($bankNo);
        $bankInfo->bank_ischeck = 1;
        $bankInfo->bank_checkser = $this->session->userid;
        return $this->save($bankInfo);
    }


    public function mergeBank($bankNo, $mergeNo)
    {
        //删除被合并的银行卡
        $mergeWhere['bank_no'] = $mergeNo;
        $this->where($mergeWhere)->delete();

        //将所有用户银行卡 为现有银行的 更新为合并后的银行
        // $userBankData = new BankAccountData();
        // $userBanks = $userBankData->getFinanceBanks($mergeNo);
        // if (!$userBanks->isEmpty()) {
        //     foreach ($userBanks as $val) {
        //         $accountNo = $val->account_no;
        //         $userBankData->saveBank($accountNo,$bankNo);
        //     }
        // }

        //将所有为 $mergeNo 银行的支行 的银行修改为 合并后的银行
        $sysBankData = new BankData();
        $banks = $sysBankData->getFinanceBanks($mergeNo);
        if (!$banks->isEmpty()) {
            foreach ($banks as $bank) {
                $id = $bank->id;
                $sysBankData->saveBank($id, $bankNo);
            }
        }
    }

    /**
     * 添加银行卡
     *
     * @param  $bankNo 银行号 
     * @param  $bankCard 银行卡号 
     * @param  $name 名称 
     * @param  $branchName 支行名称
     * 
     * 增加redis 锁
     * @author zhoutao
     * @date   2017.10.10
     */
    public function addBankCard( $bankCard, $name, $branchName, $phone = null, $bankNo = null)
    {
        $lk = new LockData();
        $bankCard = str_replace(' ', '', $bankCard);
        $key = "addBankCard" . $bankCard;
        $lk->lock($key);

        //检查银行卡是否存在
        $userBankData = new UserBankAccountData();
        $userBankCard = $userBankData->getUserBank($bankCard);
        if($userBankCard != null )
            return $userBankCard->account_no;

        $userData = new UserData;
        $idno = $userData->getUserIdno($this->session->userid);

        //查询银行卡信息
        $payFac = new PaymentServiceFactory();
        $service = $payFac -> createService();
        $bkInfo = $service-> GetBankCardInfo($bankCard,  $name, $idno, $phone);
        $bankname = $bkInfo -> bank_name;
        // $bankcode = $bkInfo -> bank_code;
    info(json_encode($bkInfo));
    
        // $bkInfo = $this->getByNo($bankNo);
        // dump($bkInfo);
        // $bankname = $bkInfo->bank_name;

        //查询银行id 
        $modelclass = $this->modelclass;

        $sysBankInfo = $modelclass :: where (
            [
                "bank_name"=> $bankname
            ]
        )->first();

        if($sysBankInfo == null)
        {
            throw \Exception("银行不存在");
        }

        $banktype = $sysBankInfo -> bank_no;


        //查询银行名称 
        $sysBankData = new BankData();
        $bankInfo = $sysBankData->getBank($branchName, $banktype);
        if ($bankInfo === null) {
            $bankId = $sysBankData->addBank($branchName, $banktype);
        } else {
           $bankId = $bankInfo->id;
        }


        //查询支行信息
        // $bank = $sysBankData->getFinanceBank($bankNo);
        $bank = $sysBankData->getFinanceBranchBank($banktype, $branchName);
        if ($bank == null) {
            //增加一个该银行的支行
            $bankname = $branchName;
            $bankid = $sysBankData->addBranchBank($bankname, $banktype);
        } else {
            //选取该支行为 该用户 该卡的支行
            $bankid = $bank->id;
        }

        //添加信息

        /***查询支行
      **/

        //查询银行卡
        $userBankData = new UserBankAccountData();
        $userBankCard = $userBankData->getUserBank($bankCard);
        if ($userBankCard == null) {
            //创建银行卡
            if (empty($phone)) {
                $userBankCardInfo = $userBankData->addUserBank($bankCard, $name, $bankid);
            } else {
                $userBankCardInfo = $userBankData->add($bankCard, $name, $bankid, $phone);
            }
            
        } else {
            //是否更新支行
            if ($userBankCard->account_bank != $bankid || $userBankCard->account_name != $name) {
                //更新支行
                $userBankData->saveUserBranchBank($bankCard, $bankid, $name);
            }
            //更新预留手机号
            if (!empty($phone)) {
                $userBankData->saveUserid($bankCard);
                $userBankData->saveMobile($bankCard, $phone);
                $userBankData->saveUserName($bankCard, $name);
            }
        }

        $lk->unlock($key);
        return $bankCard;
    }
}
