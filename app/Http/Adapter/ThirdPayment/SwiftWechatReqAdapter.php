<?php
namespace App\Http\Adapter\ThirdPayment;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class SwiftWechatReqAdapter extends IAdapter
{
    protected $mapArray = [
         "codeimg"=>"code_img_url",
         "codetext"=>"sys_3rd_name",
         "timelimit"=>"sys_3rd_account",
         "rechargeno"=>"sys_3rd_key",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
