<?php
namespace App\Http\Adapter\Report;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ReportUserrbSubDayInfoAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"userid"=>"report_user"
        ,"username"=>"report_user_name"
        ,"usermobile"=>"report_user_mobile"
        ,"invuserid"=>"report_invuser_id"
        ,"invusername"=>"report_invuser_name"
        ,"invusermobile"=>"report_invuser_mobile"
        ,"invuserrbbuycount"=>"report_invuser_rbbuy_count"
        ,"invuserrbbuycash"=>"report_invuser_rbbuy_cash"
        ,"invuserrbbuyreturncash"=>"report_invuser_rbbuy_return_cash"
        // ,"start"=>"report_start"
        // ,"end"=>"report_end"
    ];
    protected $dicArray = [

    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
