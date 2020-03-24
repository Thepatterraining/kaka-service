<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusData;

class ConfirmBonus extends Controller
{
    protected $validateArray=[
        "bonusNo"=>"required|doc:bonus,PBS01",
        "confirm"=>"required|boolean",
    ];

    protected $validateMsg = [
        "confirm.required"=>"请输入同意还是拒绝!",
        "bonusNo.required"=>"请输入分红单号!",
        "bonusNo.boolean"=>"请输入true and false!",
    ];

    /**
     * 审核分红
     *
     * @param $bonusNo 分红单号
     * @param $confirm true and false
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $confirm = $request['confirm'];
        $bonusNo = $request['bonusNo'];

        $data = new ProjBonusData;

        if ($confirm) {
             $data->BonusTrue($bonusNo);
        } else {
            $data->BonusFalse($bonusNo);
        }
        
        
        $this->Success();

    }
}
