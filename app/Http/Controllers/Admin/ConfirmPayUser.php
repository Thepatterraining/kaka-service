<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;

class ConfirmPayUser extends Controller
{
    protected $validateArray=[
        "payNo"=>"required",
        "confirm"=>"required|boolean",
    ];

    protected $validateMsg = [
        "payNo.required"=>"请输入单号!",
        "confirm.required"=>"请输入true and false!",
        "confirm.boolean"=>"请输入布尔值!",
    ];

    /**
     * 审核返佣
     *
     * @param $payNo 报表单号
     * @param $confirm true and false
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $payNo = $request['payNo'];
        $confirm = $request['confirm'];

        $data = new PayUserData;

        if ($confirm) {
            $data->payTrue($payNo);
        } else {
            $data->payFalse($payNo);
        }
        
        
        $this->Success(true);

    }
}
