<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Activity\ItemData;

class InfoData extends IDatafactory
{
    protected $no = 'activity_no';

    protected $modelclass = 'App\Model\Activity\Info';
    
     const ACTIVITY_NEW = "AS00";
     const ACTIVITY_RUN = "AS01";
     const ACTIVITY_END = "AS02";
     const ACTIVITY_TERMINAL = "AS03";


     const LIMIT_TIME = "AL01";
     const LIMIT_COUNT = "AL02";

    const ITEM_VOUCHER = "AT01";

    /**
     * 添加活动
     *
     * @param   $no 活动编号
     * @param   $name 名称
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @param   $type 类型
     * @param   $event 时间
     * @param   $limitCount 数量
     * @param   $count 实际数量
     * @param   $filter 条件
     * @param   $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addInfo($no, $name, $start, $end, $type, $event, $limitCount, $count, $filter, $status)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('SA');
        $model = $this->newitem();
        $model->activity_no = $no;
        $model->activity_name = $name;
        $model->activity_start = $start;
        $model->activity_end = $end;
        $model->activity_limittype = $type;
        $model->activity_event = $event;
        $model->activity_limitcount = $limitCount;
        $model->activity_count = $count;
        $model->activity_filter = $filter;
        $model->activity_status = $status;
        return $model->save();
    }

    public function addActivityLimitCount($name, $start, $end, $limitCount)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('SA');
        $model = $this->newitem();
        $model->activity_no = $no;
        $model->activity_name = $name;
        $model->activity_start = $start;
        $model->activity_end = $end;
        $model->activity_limittype = InfoData::LIMIT_COUNT;
        $model->activity_event = "";
        $model->activity_limitcount = $limitCount;
        $model->activity_count = 0 ;
        $model->activity_filter = "";
        $model->activity_status =InfoData::ACTIVITY_NEW;
        $model->save();
        return $model;
    }

    /* Add Voucher To Activity
    */
    public function addVoucher($no, $voucherNo)
    {
        $itemData  = new ItemData();
        $itemData->addItem($no, InfoData::ITEM_VOUCHER, $voucherNo);
    }

    /**
     * 增加了活动邀请码
     *
     * @param   $code 活动邀请码
     * @author  zhoutao
     * @version 0.2
     * @date    2017.4.2
     *
     * 添加活动
     * @param   $model model类型
     * @param   $event 事件
     * @param   $count 实际数量
     * @param   $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.31
     */
    public function add($model, $event, $count, $status, $no, $code)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('SA');
        $model->activity_no = $no;
        $model->activity_event = $event;
        $model->activity_count = $count;
        $model->activity_status = $status;
        $model->activity_code = $code;
        $this->create($model);
        return $no;
    }

    /**
     * 修改活动状态
     *
     * @param   $no 活动编号
     * @param   $status 状态
     * @return  mixed
     * @authro  zhoutao
     * @version 0.1
     */
    public function saveStatus($no, $status)
    {
        $model = $this->getByNo($no);
        $model->activity_status = $status;
        return $model->save();
    }

    public function saveCount($where, $count)
    {
        $model = $this->findForUpdate($where);
        $model->activity_count = $model->activity_count + $count;
        return $model->save();
    }

    /**
     * 查找活动
     *
     * @param   $code 邀请码
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function getCodeInfo($code)
    {
        $model = $this->newitem();
        $info = $model->where('activity_code', $code)->first();
        return $info;
    }

    /**
     * 给用户添加现金券
     *
     * @param   $activityNo 活动编号
     * @param   $userid 用户id
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function addUserActivity($activityNo, $userid)
    {
        $itemData = new ItemData();
        $itemlist = $itemData->getItem($activityNo);
        if (!$itemlist->isEmpty()) {
            foreach ($itemlist as $k => $v) {
                $voucherNo = $v->activity_itemno;

                //查现金券
                $voucherInfoData = new VoucherInfoData();
                $voucherInfo = $voucherInfoData->getByNo($voucherNo);
                if ($voucherInfo == null) {
                    continue;
                }
                $timespan = $voucherInfo->voucher_timespan;
                $outtime = date('U') + $timespan;

                //发现金券
                $voucherData = new VoucherStorageData();
                $no = '1';
                $voucherData = $voucherData->addStorage($no, $voucherNo, $activityNo, $userid, $outtime);
                if ($voucherData === false) {
                    return false;
                }
                //通知用户
                $this->AddEvent("Voucher_Check", $userid, $voucherNo);

                //更新现金券发放数量
                $voucherRes = $voucherInfoData->saveVoucherCount($voucherInfo, 1);
                if ($voucherRes === false) {
                    return false;
                }
            }
            //更新活动实际发生数量
                $where['activity_no'] = $activityNo;
                $activiInfoRes = $this->saveCount($where, 1);
            if ($activiInfoRes === false) {
                return false;
            }
        }
    }

    /**
     * 注册时候查询活动
     *
     * @param   $userType 用户类型
     * @param   $code 邀请码
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.14
     */
    public function regActivity($userType, $code)
    {
        $codeRes = '';
        $activityNo = '';
        $res = [];
        $invitationData = new InvitationCodeData();
        if ($userType != null) {
            //查询邀请注册设置表，拿到活动编号
            $regcofigData = new RegCofigData();
            $regcofigInfo = $regcofigData->getInfo($userType);
            if ($regcofigInfo != null) {
                $activityNo = $regcofigInfo->invite_activitycode;
            }
        } else {
            if (!empty($code)) {
                //查邀请码是否为活动邀请码
                $activityInfo = $this->getCodeInfo($code);

                if ($activityInfo != null) {
                    $activityNo = $activityInfo->activity_no;
                } else {
                    //查邀请码是否为活动邀请码 activity_invitationcode
                    $invitation = $invitationData->getByNo($code);
                    if ($invitation != null) {
                        $codeRes = 'INVITATION';
                        $activityNo = $invitation->invite_activity;
                    }
                }
            }
        }
        $res['codeRes'] = $codeRes;
        $res['activityNo'] = $activityNo;
        return $res;
    }

    public function getActivities()
    {
        $model = $this->modelclass;
        return $model::get();
    }
}
