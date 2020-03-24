<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\BankAccountData;
use App\Data\User\UserBankCardData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\FinanceBankData;
use App\Data\API\Payment\PaymentServiceFactory;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;

class BindUserBankCard extends Controller
{
    protected $validateArray=[
        "bankCard"=>"required|digits_between:16,19",
        "phone"=>"required",
        "verify"=>"required"
    ];

    protected $validateMsg = [
        "bankCard.required"=>"请输入银行卡号!",
        "bankCard.digits_between"=>"银行卡号最小16位,最大19位!",
        "phone.required"=>"请输入手机号!",
        "verify.required"=>"请输入验证码!",
        "name.required"=>"请输入姓名!",
        "idno.required"=>"请输入身份证号!",
    ];

    /**
     * @api {post} login/bank/bindbankcard 绑定用户银行卡
     * @apiName bindbankcard
     * @apiGroup bankcard
     * @apiVersion 0.0.1
     *
     * @apiParam {string} bankCard 银行卡号
     * @apiParam {string} phone 手机号
     * @apiParam {string} verify 验证吗
     * @apiParam {string} bankNo 银行号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      bankCard : '6814 **** 6418',
     *      phone  : '132****42',
     *      verify : 'KaKamfPwd8080',
     *      bankNo : 5
     *      
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : '6814 **** 6418'
     *  }
     */
    public function run()
    {
        // return $this->result = [
        //     "code" => 99998,
        //     "msg" =>  "暂时禁止使用，请使用线下充值",
        //     "datetime"=>Date("Y-m-d H:i:s")
        // ];;
        //接收数据
        $request = $this->request->all();
        $bankCard = $request['bankCard'];
        $phone = $request['phone'];


        $branchName = "默认支行";

        if (array_key_exists("branchName", $request)) {
            $branchName = $request['branchName'];
        }

        //处理银行卡号
        $bankCard = str_replace(' ', '', $bankCard);
        if (!is_numeric($bankCard)) {
            return $this->Error(ErrorData::$BANK_CARD_FALSE);
            
        }

        // dump($this->session);
        $userData = new UserData;
        $name = $userData->getUserName($this->session->userid);
        $idno = $userData->getUserIdno($this->session->userid);

        //调用第三方确认信息
        $serviceFac = new PaymentServiceFactory();
        $pay = $serviceFac->createService();
    info($bankCard.$name. $idno. $phone);
        $result = $pay->ValidBankCard($bankCard, $name, $idno, $phone);

        if ($result->success) {
            //执行
            $financeBankData = new FinanceBankData();
            $userBankId = $financeBankData->addBankCard($bankCard, $name, $branchName, $phone);
            if ($userBankId) {
                //return $this->Error($userBankId);
            }
            $bankAccountData = new BankAccountData();
            $bankAccountAdapter = new UserBankCardAdapter();
            $bankadapter = new BankAdapter();
            $bankdata = new BankData();
            $bankLog = new BankLogic;
            $item = $bankAccountData->getByNo($userBankId);
            $item2Add = $bankAccountAdapter->getFromModel($item, true);
            $bankModel = $bankdata->get($item2Add["bank"]);
            if ($bankModel!= null) {
                     $bankContract = $bankadapter->getFromModel($bankModel);
                   $item2Add ["bank"]=  $bankContract;
                   $item2Add['bank']['id'] = $bankLog->getBankInfo($item2Add['bank']['id']);
                   $userBankCard = $item2Add;
            }
            $this->Success($userBankCard);
        } else {
            $this->result = $result;
        }
        
        //查询绑定了几张银行卡
        // $userBankData = new BankAccountData();
        // $count = $userBankData->getUserBankCount();
        // if ($count == 5) {
        //     return $this->Error(808003);
        // }

        
    }
}
