<?php
namespace App\Data\API\Payment;

interface IFastPaymentService
{

    function ValidBankCard($cardno,$username,$id,$mobile);
    function RequireSms($docno,$mobile);
    function PreparePay($docno,$date,$amount);
    function ConfirmPay($docno,$docdate,$userid,$cardno,$username,$id,$mobile,$chkcode);
    function GetBankCardInfo($cardno, $username, $id, $mobile);
}