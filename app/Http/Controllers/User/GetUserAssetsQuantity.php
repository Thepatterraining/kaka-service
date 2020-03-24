<?php

namespace App\Http\Controllers\User;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\CoinAccountData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\InvitationData;
use App\Data\User\BankAccountData;
use App\Data\Trade\TranactionSellData;

class GetUserAssetsQuantity extends Controller
{
    protected $validateArray=[
        
    ];

    protected $validateMsg = [
        
    ];

    /**
     * 查询用户中心参数
     */
    public function run()
    {
        //查询项目数量
        $coinAccountData = new CoinAccountData;
        $coinCount = $coinAccountData->getUserCoinCount();

        //查询代金券数量
        $voucherData = new VoucherStorageData;
        $voucherCount = $voucherData->getUserVouchercount();

        //优惠券过期
        $voucherData->overdue();
        
        //查询邀请金额
        $invitationData = new InvitationData;
        $invitationAmount = $invitationData->getUserInvitationAmount();

        //查询绑定银行卡数量
        $userBankAccountData = new BankAccountData;
        $userBankCardCount = $userBankAccountData->getUserBankCount();

        //查询正在卖出的项目数量
        $transSellData = new TranactionSellData;
        $userSellCount = $transSellData->getUserCount();

        $res['coinCount'] = $coinCount;
        $res['voucherCount'] = $voucherCount;
        $res['invitationAmount'] = $invitationAmount;
        $res['userBankCardCount'] = $userBankCardCount;
        $res['userSellCount'] = $userSellCount;

        return $this->Success($res);

    }
}
