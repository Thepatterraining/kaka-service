<?php
namespace App\Data\Common;
use App\Common\BoolExpression\IValExpression;
use App\Data\User\UserData;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use App\Data\IDataFactory;

class LeftExpFactory extends IDataFactory implements IValExpression
{
    public function __construct($userId)
    {
        $this->userId=$userId;
        // $this->userId=1;
    }

    /**左值转换
     * @param value 左值字符串
     * @author liu
     * @version 0.1
     */
    public function GetExp($value)
    {
        // dump($value);
        switch($value)
        {
            case "reg_time":
            {
                $userData=new UserData;
                $model=$userData->newitem();
                $res=$model->where('id',$this->userId)->first();
                return $res->created_at;
                break;
            }
            case "login_time":
            {
                $userData=new UserData;
                $model=$userData->newitem();
                $res=$model->where('id',$this->userId)->first();
                return $res->user_lastlogin;
                break;
            }
            case "cash_availble":
            {
                $cashAcountData=new CashAccountData;
                $model=$cashAcountData->newitem();
                $res=$model->where('account_userid',$this->userId)->first();
                return $res->account_cash;
                break;
            }
            case "cash_pending":
            {
                $cashAcountData=new CashAccountData;
                $model=$cashAcountData->newitem();
                $res=$model->where('account_userid',$this->userId)->first();
                return $res->account_pending;
                break;
            }
            default:
            {
                if(strstr($value,"_")==true)
                {
                    $tmp=explode("_",$value);
                    if(count($tmp)==2 && (($tmp[0]=="available")||($tmp[0]=="pending")))
                    {
                        if($tmp[0]=="available")
                        {
                            $coinAcountData=new CoinAccountData;
                            $model=$coinAcountData->newitem();
                            $res=$model->where('usercoin_account_userid',$this->userId)
                                        ->where('usercoin_cointype',$tmp[1])
                                        ->first();
                            return $res->usercoin_cash;   
                            break;
                        }
                        else
                        {
                            $coinAcountData=new CoinAccountData;
                            $model=$coinAcountData->newitem();
                            $res=$model->where('usercoin_account_userid',$this->userId)
                                        ->where('usercoin_cointype',$tmp[1])
                                        ->first();
                            return $res->usercoin_pending;   
                            break;
                        }
                    }
                }
                return null;
                break;
            }   
        }
    }
}