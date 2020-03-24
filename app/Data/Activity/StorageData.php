<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class StorageData extends IDatafactory
{

    protected $no = 'activity_storage_no';
    protected $modelclass = 'App\Model\Activity\Storage';

    /**
     * 添加活动申请
     *
     * @param   $activity 活动编号
     * @param   $status 状态 ASS00
     * @param   $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function add($activity, $status, $userid)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('ASN');
        $model = $this->newitem();
        $model->activity_storage_no = $no;
        $model->activity_no = $activity;
        $model->activity_storage_status = $status;
        $model->activity_storage_userid = $userid;
        return $this->create($model);
    }

    /**
     * 修改状态
     *
     * @param   $no 编号
     * @param   $status 状态
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function saveStatus($no, $status)
    {
        $info = $this->getByNo($no);
        $info->activity_storage_status = $status;
        return $this->save($info);
    }

    /**
     * 同意发券
     *
     * @param   $no 编号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function trueConfirm($no)
    {
        $info = $this->getByNo($no);
        $activity = $info->activity_no;
        $userid = $info->activity_storage_userid;

        $activityData = new InfoData();
        $res = $activityData->addUserActivity($activity, $userid);
        if ($res === false) {
            return false;
        }

        $res = $this->saveStatus($no, 'ASS01');
        if ($res === false) {
            return false;
        }
        return $res;
    }

    /**
     * 拒绝发券
     *
     * @param   $no 编号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function falseConfirm($no)
    {
        $res = $this->saveStatus($no, 'ASS02');
        return $res;
    }
}
