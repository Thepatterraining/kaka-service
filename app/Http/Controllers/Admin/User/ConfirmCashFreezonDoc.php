<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;
use App\Data\User\CashFreezonDocData;

class ConfirmCashFreezonDoc extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:usercashfrozen,UCFDS01",
        "confirm"=>"required|boolean",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单号!",
        "confirm.required"=>"请输入true and false!",
        "confirm.boolean"=>"请输入布尔值!",
    ];

    /**
     * 审核用户人民币冻结解冻
     *
     * @param $no 单号
     * @param $confirm true and false
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $no = $request['no'];
        $confirm = $request['confirm'];

        $data = new CashFreezonDocData;

        if ($confirm) {
            $data->trueFrozen($no);
        } else {
            $data->falseFrozen($no);
        }
        
        
        $this->Success();

    }
}
