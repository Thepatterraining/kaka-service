<?php
namespace App\Http\Adapter\Item;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class InfoAdapter extends IAdapter
{
    protected $mapArray = [
         "cointype"=>"coin_type"
        ,"name"=>"name"
        ,"kk_name"=>"kk_name"
        ,"compound"=>"compound"
        ,"layout"=>"layout"
        ,"diqu"=>"diqu"
        ,"trade"=>"trade"
        ,"number"=>"number"
        ,"age"=>"age"
        ,"space"=>"space"
        ,"rowards"=>"rowards"
        ,"renovation"=>"renovation"
        ,"school"=>"school"
        ,"metro"=>"metro"
        ,"price"=>"price"
        ,"amount"=>"amount"
        ,"term"=>"term"
        ,"exchange_time"=>"exchange_time"
        ,"school_district"=>"school_district"
        ,"sublet"=>"sublet"
        ,"rightDate"=>"rightDate"
        ,"bonusDate"=>"bonusDate"
        ,"investment"=>"investment"
        ,"bonusRate"=>"bonus_rate"
        ,"bonusCycle"=>"bonus_cycle"
        ,"bonusPeriods"=>"bonus_periods"
        ,"bonusRightDate"=>"bonus_right_date"
        ,"bonusdate"=>"bonus_date"
        ,"rose"=>"rose"
        ,"firstYearRose"=>"first_year_rose"
        ,"secondYearRose"=>"second_year_rose"
        ,"thirdYearRose"=>"third_year_rose"
        ,"fourthYearRose"=>"fourth_year_rose"
        ,"fifthYearRose"=>"fifth_year_rose"
        ,"insurance"=>"insurance"
        ,"bank"=>"bank"
        ,"starttime"=>"starttime"
        ,"houseType"=>"house_type"
        ,"leaseType"=>"lease_type"
        ,"housePurpose"=>"house_purpose"
        ,"region"=>"region"
        ,"traffic"=>"traffic"
        ,"houseRegion"=>"house_region"
        ,"scale"=>"scale"
    ];

    protected $dicArray = [
        "sublet"=>"item_sublet",
        "houseType"=>"house_type",
    ];

    protected $fmtArray = [
        "firstYearRose"=>'intval($item)'
        ,"secondYearRose"=>'intval($item)'
        ,"thirdYearRose"=>'intval($item)'
        ,"fourthYearRose"=>'intval($item)'
        ,"fifthYearRose"=>'intval($item)'
        ,"scale"=>'floatval($item)'
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
