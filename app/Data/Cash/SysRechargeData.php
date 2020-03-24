<?php
namespace App\Data\Cash ;

use App\Data\Cash\UserRechargeData;
use App\Data\Cash\RechargeData;
use App\Data\Schedule\IHourSchedule;
use App\Data\CashRecharge\CashRechargeFactory;

class SysRechargeData implements IHourSchedule
{

    const CHANNEL_ID = 1;
 
    public function DealTimeoutThirdRechargeData()
    {

        $end = date("Y-m-d H:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-5 hours"));


        $userRechargeFac = new RechargeData();


        $filter= [ 
           // 
             "created_at"           =>['<',$start],
            "cash_recharge_status"   =>['=',RechargeData::STATUS_APPLY],
            "cash_recharge_type"=>['=',RechargeData::THIRDPAYMENT_TYPE]
        ];
        $userRechargeFac->queryAllWithoutPageturn(
            $filter,
            function ($item,$index) {

                $rechargeFac = new CashRechargeFactory;
                $rechargeData = $rechargeFac->createData(self::CHANNEL_ID);

                $rechargeData->rechargeFalse($item->cash_recharge_no);
                //  dump(  $item->cash_recharge_no );
            }
        );
    }
    public function hourrun()
    {
        $this->DealTimeoutThirdRechargeData();
    }
}