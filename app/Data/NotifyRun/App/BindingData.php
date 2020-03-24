<?php
namespace App\Data\NotifyRun\App;

use App\Data\IDataFactory;
use App\Data\User\UserData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\App\UserInfoAdapter;
use App\Data\Notify\INotifyDefault;
use App\Data\Lending\LendingUserData;
use App\Data\Frozen\FrozenFactory;
use App\Data\Coin\FrozenData;
use App\Data\User\CoinAccountData as UserCoinAccountData;
use App\Data\App\UserInfoData;

class BindingData extends IDataFactory implements INotifyDefault
{
    /**
     * 绑定给用户送新手标
     *
     * @param  $data 3rd_user_info data
     * @author zhoutao
     * @date   2017.11.10
     * 
     * 增加了用户注册时间检测
     * @author zhoutao
     * @date   2017.11.13
     * 
     * 停止新手标
     * @author zhoutao
     * @date 2018.07.09
     */
    public function notifyrun($data)
    {
        // $params = $data['params'];
        // $lendingDocInfoPrice = $params['price'];
        // $lendingDocInfoCoinType = $params['coinType'];
        // $lendingDocInfoCount = $params['count'];
        // $userid = $data['kkuserid'];
        // $bindTime = $data['binding_time'];
        // $lendingPlanReturnTime = date('Y-m-d H:i:s', strtotime($bindTime . '+7 day'));


        // if ($userid > 0) {
        //     $userData = new UserData;
        //     $user = $userData->get($userid);
        //     $regTime = $user->created_at->format('Y-m-d H:i:s');
        //     $qualiTime = config("activity.date");
        //     if ($regTime >= $qualiTime) {
        //         //查询用户有没有这个币种
        //         $userCoin = new UserCoinAccountData();
        //         $userCoinInfo = $userCoin->getUserCoin($lendingDocInfoCoinType, $userid);

        //         if (empty($userCoinInfo)) {
        //             $lendingUserData = new LendingUserData;
        //             $no = $lendingUserData->sysToUser($lendingDocInfoCoinType, $lendingDocInfoCount, $userid, $lendingPlanReturnTime, $lendingDocInfoPrice);
        //             $lendingUserData->sysToUserTrue($no);
        //             $frozenFac = new FrozenFactory;
        //             $frozenData = $frozenFac->CreateFrozen(FrozenData::LENDING_DOC_TYPE);
        //             $frozenData->orderFrozen($no);

        //             //通知用户
        //             $this->AddEvent(UserInfoData::SYSCOIN_TOUSER_EVENT_TYPE, $userid, $no);
        //             $data['detailtype']=UserInfoData::BINDING_TYPE;
        //             $this->CallbackQueueHandle((object)$data, config("rabbitmq.jsexname"), 'sys_message');
        //         }
        //     }
            
        // }
        
    }    
}
