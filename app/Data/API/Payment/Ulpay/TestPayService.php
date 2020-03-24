<?php
namespace App\Data\API\Payment\Ulpay;

use App\Data\API\Payment\IFastPaymentService;
use App\Data\API\Result ;
use App\Data\API\Payment\PreparePaymentResult;

/**
 * 测试用ulpay类
 * 直接返回正确数据
 *
 * @author zhoutao
 * @date   2017.8.23
 */ 
class TestPayService implements IFastPaymentService
{
   
    /**
     * 测试身份证验证
     *
     * @author zhoutao
     * @date   2017.8.23
     */
    public function ValidBankCard($cardno,$username,$id,$mobile)
    {

        $array['INFO']['RET_CODE'] = '0000';
        $array['INFO']['ERR_MSG'] = '成功';
         return $this->_getResult($array);
      
    }

    /**
     * 返回数据
     *
     * @author zhoutao
     * @date   2017.8.23
     */
    private function _getResult($array)
    {
            $result = new Result();
          $result -> code = $array["INFO"]["RET_CODE"] ;
          $result -> msg = $array["INFO"]["ERR_MSG"];
          $result -> success = $result ->code == "0000";
          return $result ;

    }

    /**
     * 发送验证码
     *
     * @author zhoutao
     * @date   2017.8.23
     */
    public function RequireSms($docno,$mobile)
    {
        
          $array['INFO']['RET_CODE'] = '0000';
        $array['INFO']['ERR_MSG'] = '成功';
         return $this->_getResult($array);
    }
    /**
     * 发起充值
     *
     * @author zhoutao
     * @date   2017.8.23
     */
    public function PreparePay($docno,$date,$amount)
    {


        $array['INFO']['RET_CODE'] = '0000';
        $array['INFO']['RET_MSG'] = '成功';
        $array['BODY']['PLAT_ORDER_NO'] = 'test'.date("YmdHis");

         $result = new PreparePaymentResult();
          $result -> code = $array["INFO"]["RET_CODE"] ;
          $result -> msg = $array["INFO"]["RET_MSG"];
          $result -> success = $result ->code == "0000";
            $result -> thirdplatdocno = $array["BODY"]["PLAT_ORDER_NO"];
    

          return $result ;
    


    }
    /**
     * 审核充值
     *
     * @author zhoutao
     * @date   2017.8.23
     */
    public function ConfirmPay($docno,$docdate,$userid,$cardno,$username,$id,$mobile,$chkcode)
    {


          $array['INFO']['RET_CODE'] = '0000';
        $array['INFO']['ERR_MSG'] = '成功';
         return $this->_getResult($array);


    }

    /**
     * 查询银行卡
     *
     * @author zhoutao
     * @date   2017.8.23
     */
    function GetBankCardInfo($cardno, $username, $id, $mobile)
    {
            
          $array['INFO']['RET_CODE'] = '0000';
        $array['INFO']['RET_MSG'] = '成功';

        $result = new Result();
        $result -> code = $array["INFO"]["RET_CODE"] ;
        $result -> msg = $array["INFO"]["RET_MSG"];
        $result -> success = $result ->code == "0000";
        // dump($array);
        return $result ;

    }

}