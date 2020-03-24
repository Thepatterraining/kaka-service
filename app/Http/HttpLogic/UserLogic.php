<?php
namespace App\Http\HttpLogic;

use App\Data\Sys\RakebackTypeData;
use App\Http\Adapter\Sys\RakebackTypeAdapter;
use App\Data\User\UserData;
use App\Data\User\BankAccountData;
use App\Http\Adapter\User\UserAdapter;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;
use App\Data\App\UserInfoData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\User\UserTypeData;
use App\Http\Adapter\User\UserTypeAdapter;
class UserLogic
{

    /**
     * 返回用户信息
     *
     * @param  $user 查出来的用户信息
     * @author zhoutao
     * @date   2017.8.21
     */ 
    public function getUser($user)
    {
        $dataFac = new UserData;
        $bankAccountData = new BankAccountData();
        $bankAccountAdapter = new UserBankCardAdapter();
        $bankadapter = new BankAdapter();
        $bankdata = new BankData();
        $bankLog = new BankLogic;
        $userInfoData = new UserInfoData;
        $userCoin = new UserCoinAccountData();

        //查询微信信息
        $wechatUser = $userInfoData->getUserByUserid($user['id']);
        $isBind = 0;
        $bindTime = 1970-01-01;
        $qualifications = 0;
        $canParticipate = 0;
        if (!empty($wechatUser)) {
            $isBind = 1;
            $bindTime = $wechatUser->binding_time;
            //注册时间大于活动开始时间
            $regTime = $dataFac->getRegTime($user['mobile']);
            $qualiTime = config("activity.date");
            if ($regTime >= $qualiTime) {
                
                //查询用户有没有这个币种
                $coinType = config("activity.newUserCoin");
                $userCoinInfo = $userCoin->getUserCoin($coinType, $user['id']);
                if (empty($userCoinInfo)) {
                    $qualifications = 1;
                    $canParticipate = 1;
                }
            }
            
        } else {
            //查询用户有没有这个币种
            $coinType = config("activity.newUserCoin");
            $userCoinInfo = $userCoin->getUserCoin($coinType, $user['id']);
            if (empty($userCoinInfo)) {
                $canParticipate = 1;
            }
        }
        $user['canParticipate'] = $canParticipate;
        $user['isBind'] = $isBind;
        $user['bindTime'] = $bindTime;
        $user['qualifications'] = $qualifications;


        $paypwdIsEmpty = $dataFac->paypwdIsEmpty();
        $user['paypwdIsEmpty'] = $paypwdIsEmpty;
        $user['isSetPaypwd'] = $paypwdIsEmpty;
            
        $items = $bankAccountData->getUserBankCards();    
        $result = [];
        foreach ($items as $item) {
            $item2Add = $bankAccountAdapter->getFromModel($item, true);
            $bankModel = $bankdata->get($item2Add["bank"]);
            if ($bankModel!= null) {
                   $bankContract = $bankadapter->getFromModel($bankModel);
                   $item2Add ["bank"]=  $bankContract;
                   $item2Add['bank']['id'] = $bankLog->getBankInfo($item2Add['bank']['id']);
                   $result[]=$item2Add;
            }
        }
        $user['userBankCards'] = $result;

        //返回返佣级别
        if (array_key_exists('currentrbtype',$user) && $user['currentrbtype'] > 0) {
            $rakebackTypeData = new RakebackTypeData;
            $rakebackType = $rakebackTypeData->get($user['currentrbtype']);
            $rakebackTypeAdapter = new RakebackTypeAdapter;
            $rakebackArray = ['lbuy','tbuy','name','buyrate'];
            $user['currentrbtype'] = $rakebackTypeAdapter->getDataContract($rakebackType, $rakebackArray);
        } else {
            $user['currentrbtype'] = [];
            $user['currentrbtype']['lbuy'] = 0;
            $user['currentrbtype']['tbuy'] = 0;
            $user['currentrbtype']['name'] = 0;
            $user['currentrbtype']['buyrate'] = 0;
        }
        //得到用户类型信息
        $userTypeFac = new UserTypeData();
        
        $userTypeAdp = new UserTypeAdapter;
        if (array_key_exists("currenttype",$user) == true){ 
        $userTypeId = $user["currenttype"];
        $userTypeItem = $userTypeFac -> get($userTypeId);
        //dump($userTypeItem);
        $userTypeInfo = $userTypeAdp->getDataContract($userTypeItem );
        $user["currenttype"] = $userTypeInfo;
        }
        
        return $user;
    }
}
