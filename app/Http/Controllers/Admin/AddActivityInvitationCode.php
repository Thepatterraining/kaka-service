<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Activity\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddActivityInvitationCode extends Controller
{
    protected $validateArray=[
        "userid"=>"required|exists:sys_user,id",
        "activityNo"=>"required|exists:activity_info,activity_no",
        "count"=>"required",
        "type"=>"required|dic:invite_type",
        "maxCount"=>"required",
    ];

    protected $validateMsg = [
        "userid.required"=>"请输入用户id",
        "activityNo.required"=>"请输入活动编号",
        "count.required"=>"请输入要创建的数量",
        "userid.exists"=>"用户不存在",
        "activityNo.exists"=>"活动不存在",
        "type.required"=>"请输入邀请码类型",
        "maxCount.required"=>"请输入最大可用数量",
    ];

    /**
     *
     * @api {post} admin/activity/addinvitationcode 生成邀请码
     * @apiName activityaddinvitationcode
     * @apiGroup Admin
     * @apiVersion 0.0.1
     *
     * @apiParam {string} userid 用户id
     * @apiParam {string} activityNo 活动编号
     * @apiParam {string} type 活动类型 INVC01 用户邀请码 INVC02 活动邀请码
     * @apiParam {string} maxCount 最大可用数量
     * @apiParam {string} count 生成多少个
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      userid : 1,
     *      activityNo : 'SA20170402193540898',
     *      type : 'INVC02',
     *      maxCount : '40',
     *      count : 100,
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : true
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $userid = $request['userid'];
        $activityNo = $request['activityNo'];
        $type = $request['type'];
        $maxCount = $request['maxCount'];
        $count = $request['count'];

        $data = new InvitationCodeData();
        //循环插入 $count 条邀请码
        for ($i = 0; $i < $count; $i++) {
            $data->addCode($activityNo, $userid, $maxCount, $type);
        }

        $this->Success();
    }
}
