<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\StorageData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserActivityConfirm extends Controller
{
    protected $validateArray=[
        "confirm"=>"required|boolean",
        "no"=>"required|exists:activity_storage,activity_storage_no",
    ];

    protected $validateMsg = [
        "confirm.required"=>"请输入确认值!",
        "no.required"=>"请输入单号!",
        "no.exists"=>"单号不存在!",
        "confirm.boolean"=>"确认值类型不正确!",
    ];

    /**
     * 审核发券
     *
     * @param   $no 编号
     * @param   $confirm 是否审核
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function run()
    {
        $request = $this->request->all();
        $no = $request['no'];
        $confirm = $request['confirm'];

        $data = new StorageData();

        $info = $data->getByNo($no);
        if ($info == null) {
            return $this->Error(802006);
        }
        if ($info->activity_storage_status != 'ASS00') {
            return $this->Error(802006);
        }

        if ($confirm) {
            //审核成功 执行发券 修改状态
            $res = $data->trueConfirm($no);
        } else {
            //审核失败 修改状态
            $res = $data->falseConfirm($no);
        }

        return $this->Success('审核成功');
    }
}
