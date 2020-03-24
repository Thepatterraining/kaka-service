<?php

namespace App\Http\Controllers\Admin\Cash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;
use App\Data\Cash\JournalDocData;

class ConfirmJournalDoc extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:cashjournaldoc,CJDS01",
        "confirm"=>"required|boolean",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单号!",
        "confirm.required"=>"请输入true and false!",
        "confirm.boolean"=>"请输入布尔值!",
    ];

    /**
     * 审核外部转账
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

        $data = new JournalDocData;
       
        if ($confirm) {
            $data->trueJournalDoc($no);
        } else {
            $data->falseJournalDoc($no);
        }
        
        
        $this->Success();

    }
}
