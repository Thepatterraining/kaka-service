<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Data\Sys\BankData;
use Illuminate\Support\Facades\DB;
use App\Data\API\Payment\PaymentServiceFactory ;

class UserBankCardData extends IDataFactory
{

    protected $modelclass = 'App\Model\User\BankAccount';
    protected $no = "account_no";


    /**
     * 增加一张银行卡
     *
     * @author  geyunfei(geyunfei@kakamf.com)
     * @version 0.1
     * @param   string bankno 银行卡号
     * @param   string bankname 银行名称
     * @param   string banktype 银行类型
     */
    public function addBankCard($bankno)
    {

        //查找银行信息，如果没有添加这个银行
 
        $bankData = new BankData();
        

        $payFac = new PaymentServiceFactory();
        $service = $payFac -> createService();
        $bkInfo = $service-> GetBankCardInfo($bankno);
        $bankname = $bkInfo -> bank_name;
        $bankcode = $bkInfo -> bank_code;
        $bankInfo = $bankData->getBank($bankname, $banktype);
        if ($bankInfo === null) {
            $bankId = $bankData->addBank($bankname, $banktype);
        } else {
            $bankId = $bankInfo->id;
        }
        //查找用户姓名
        $userData = new UserData();
        $userInfo = $userData->get($this->session->userid);
        //添加用户的银行卡
        $userBankData = new BankAccountData();
        $userBank = $userBankData->getUserBankInfo($bankno);
        if ($userBank != null) {
            return false;
        }
        $res = $userBankData->addUserBank($bankno, $userInfo->user_name, $bankId);
 
        return $res;
    }

    /**
     * 得到当前用户的银行卡列表
     *
     * @author  geyunfei(geyunfei@kakamf.com)
     * @version 0.1
     */
    public function getBankCardlist()
    {
    }
}
