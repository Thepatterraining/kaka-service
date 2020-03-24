<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\VoucherInfoData;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddVoucher extends Controller
{
    protected $validateArray=[
        "name"=>"required",
        "type"=>"required|dic:voucher_type",
        "val1"=>"required",
        "timespan"=>"required",
        "locktime"=>"required",
        "count"=>"required|integer",
    ];

    protected $validateMsg = [
        "name.required"=>"请输入现金券名称",
        "type.required"=>"请输入现金券类型",
        "val1.required"=>"请输入值",
        "timespan.required"=>"请输入超时时间",
        "locktime.required"=>"请输入锁定时间",
        "count.required"=>"请输入发放数量",
        "count.integer"=>"发放数量必须是数字",
    ];

    /**
     * 添加现金券
     *
     * @param   name 现金券名称
     * @param   type 类型
     * @param   val1 值
     * @param   timespan 超时时间 秒
     * @param   locktime 锁定时间秒
     * @param   count 发放数量
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $name = $request['name'];
        $type = $request['type'];
        $val1 = $request['val1'];
        $timespan = $request['timespan'];
        $locktime = $request['locktime'];
        $count = 0;
        $val2 = $request['val2'];
        $val3 = 0;
        $val4 = 0;
        $vmodel = '';
        $event = '';
        $filter = '';
        $usercount = 0;
        $timeout = 0;
        $data = new VoucherInfoData();
        $doc = new DocNoMaker();
        $no = $doc->Generate('VCN');
        $res = $data->addInfo($no, $name, $type, $val1, $val2, $val3, $val4, $vmodel, $event, $filter, $timespan, $count, $usercount, $timeout, $locktime);
        if ($res === false) {
             return $this->Error();
        }
        $this->Success($no);
    }
}
